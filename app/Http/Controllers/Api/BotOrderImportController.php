<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\PaymentStatus;
use App\Services\OrderSource;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class BotOrderImportController extends Controller
{
    private const SIGNATURE_TTL_SECONDS = 300;

    public function __invoke(Request $request): JsonResponse
    {
        abort_unless(
            (bool) config('services.bot_order_sync.enabled'),
            Response::HTTP_SERVICE_UNAVAILABLE
        );

        $rawBody = $request->getContent();
        $this->verifySignature(
            $rawBody,
            (string) $request->header('X-Cvetofor-Timestamp'),
            (string) $request->header('X-Cvetofor-Signature')
        );

        $payload = Validator::make($request->json()->all(), [
            'platform' => ['required', 'string', 'in:telegram,max'],
            'order_id' => ['required', 'integer', 'min:1'],
            'payment_id' => ['nullable', 'string', 'max:255'],
            'city_id' => ['required', 'integer', 'min:1'],
            'market_id' => ['required', 'integer', 'min:1'],
            'group_product_id' => ['required', 'integer', 'min:1'],
            'product_price_id' => ['nullable', 'integer', 'min:1'],
            'product_title' => ['required', 'string', 'max:500'],
            'amount' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_contact' => ['required', 'string', 'max:100'],
            'recipient_name' => ['required', 'string', 'max:100'],
            'recipient_phone' => ['required', 'string', 'max:100'],
            'recipient_address' => ['required', 'string', 'max:1000'],
            'delivery_date' => ['nullable', 'date_format:Y-m-d'],
            'time_interval' => ['nullable', 'string', 'max:100'],
            'with_post_card' => ['required', 'boolean'],
            'post_card_text' => ['nullable', 'string', 'max:5000'],
            'compound' => ['nullable', 'string', 'max:20000'],
            'created_at' => ['required', 'date'],
            'paid_at' => ['required', 'date'],
        ])->validate();

        $result = DB::transaction(function () use ($payload, $rawBody): array {
            DB::table('bot_order_imports')->insertOrIgnore([
                'platform' => $payload['platform'],
                'external_order_id' => $payload['order_id'],
                'external_payment_id' => $payload['payment_id'] ?? null,
                'payload_hash' => hash('sha256', $rawBody),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $import = DB::table('bot_order_imports')
                ->where('platform', $payload['platform'])
                ->where('external_order_id', $payload['order_id'])
                ->lockForUpdate()
                ->first();

            abort_unless($import, Response::HTTP_CONFLICT);

            if ($import->site_order_id) {
                return [
                    'site_order_id' => (int) $import->site_order_id,
                    'created' => false,
                ];
            }

            $marketExists = DB::table('markets')
                ->where('id', $payload['market_id'])
                ->where('city_id', $payload['city_id'])
                ->whereNull('deleted_at')
                ->exists();

            abort_unless($marketExists, Response::HTTP_UNPROCESSABLE_ENTITY);

            $priceQuery = DB::table('product_prices')
                ->where('group_product_id', $payload['group_product_id'])
                ->where('market_id', $payload['market_id'])
                ->whereNull('deleted_at');

            if (! empty($payload['product_price_id'])) {
                $priceQuery->where('id', $payload['product_price_id']);
            }

            $productPrice = $priceQuery->orderBy('id')->first();
            abort_unless($productPrice, Response::HTTP_UNPROCESSABLE_ENTITY);

            $paidStatusId = DB::table('payment_statuses')
                ->where('code', PaymentStatus::PAID)
                ->value('id');
            $issuedStatusId = DB::table('order_statuses')
                ->where('code', OrderStatus::ISSUED)
                ->value('id');
            $paymentMethodId = DB::table('payments')
                ->where('code', Payment::YOOKASSA)
                ->whereNull('deleted_at')
                ->value('id');

            abort_unless(
                $paidStatusId && $issuedStatusId && $paymentMethodId,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );

            $nextOrderNumber = ((int) DB::table('orders')->max('num_order')) + 1;

            $amount = round((float) $payload['amount'], 2);
            $createdAt = Carbon::parse($payload['created_at']);

            $siteOrderId = DB::table('orders')->insertGetId([
                'uuid' => (string) Str::uuid(),
                'published' => true,
                'market_id' => $payload['market_id'],
                'city_id' => $payload['city_id'],
                'payment_id' => $paymentMethodId,
                'payment_status_id' => $paidStatusId,
                'order_status_id' => $issuedStatusId,
                'phone' => $payload['customer_contact'],
                'address' => json_encode([
                    'address' => $payload['recipient_address'],
                    'coordinates' => null,
                    'apartament_number' => null,
                    'city' => DB::table('cities')
                        ->where('id', $payload['city_id'])
                        ->value('city'),
                ], JSON_UNESCAPED_UNICODE),
                'is_photo_needle' => false,
                'is_anon' => false,
                'is_policy_accepted' => true,
                'delivery_date' => $payload['delivery_date'],
                'delivery_time' => $payload['time_interval'] ?? null,
                'total_price' => $amount,
                'postcard_text' => $payload['post_card_text'] ?? null,
                'person_receiving_name' => $payload['recipient_name'],
                'person_receiving_phone' => $payload['recipient_phone'],
                'cart' => json_encode([[
                    'id' => 'bot-' . $payload['platform'] . '-' . $payload['order_id'],
                    'name' => $payload['product_title'],
                    'price' => $amount,
                    'quantity' => 1,
                    'attributes' => [],
                    'associatedModel' => [
                        'id' => (int) $productPrice->id,
                    ],
                ]], JSON_UNESCAPED_UNICODE),
                'meta' => json_encode([
                    'bot_order' => [
                        'platform' => $payload['platform'],
                        'order_id' => (int) $payload['order_id'],
                        'payment_id' => $payload['payment_id'] ?? null,
                        'compound' => $payload['compound'] ?? null,
                        'paid_at' => $payload['paid_at'],
                    ],
                ], JSON_UNESCAPED_UNICODE),
                'num_order' => $nextOrderNumber,
                'source' => OrderSource::normalize($payload['platform']),
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);

            DB::table('bot_order_imports')
                ->where('id', $import->id)
                ->update([
                    'site_order_id' => $siteOrderId,
                    'external_payment_id' => $payload['payment_id'] ?? null,
                    'payload_hash' => hash('sha256', $rawBody),
                    'imported_at' => now(),
                    'updated_at' => now(),
                ]);

            return [
                'site_order_id' => (int) $siteOrderId,
                'created' => true,
            ];
        }, 3);

        return response()->json($result, $result['created'] ? 201 : 200);
    }

    private function verifySignature(string $rawBody, string $timestamp, string $signature): void
    {
        $secret = (string) config('services.bot_order_sync.secret');

        abort_unless(
            $secret !== ''
                && ctype_digit($timestamp)
                && abs(time() - (int) $timestamp) <= self::SIGNATURE_TTL_SECONDS
                && preg_match('/^[a-f0-9]{64}$/i', $signature) === 1,
            Response::HTTP_UNAUTHORIZED
        );

        $expected = hash_hmac('sha256', $timestamp . '.' . $rawBody, $secret);
        abort_unless(hash_equals($expected, strtolower($signature)), Response::HTTP_UNAUTHORIZED);
    }
}
