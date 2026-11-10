<?php

namespace App\Http\Middleware;

use A17\Twill\Facades\TwillAppSettings;
use App\Models\DesignClick;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class DesignSplit
{
    public const COOKIE_NAME = 'design_split';
    public const COOKIE_MINUTES = 525600; // год

    public function handle(Request $request, Closure $next)
    {
        if ((TwillAppSettings::get('resource.resource.design') ?? 'dynamic') !== 'dynamic'
            || $request->is('admin', 'admin/*')) {
            return $next($request);
        }

        $split = json_decode((string) $request->cookie(self::COOKIE_NAME), true);
        $clickedOld = $request->has('set_old_view');

        if (!is_array($split) || !in_array($split['variant'] ?? null, ['new', 'old'], true)) {
            // новому посетителю вариант достаётся поочерёдно: нечётный номер счётчика — «новый»,
            // чётный — «старый»; вместе с вариантом фиксируем источник первого визита (реферер и utm)
            $split = [
                'id' => (string) Str::uuid(),
                'variant' => $clickedOld ? 'old' : (Cache::increment('design_split_counter') % 2 === 1 ? 'new' : 'old'),
                'referrer' => $request->headers->get('referer'),
                'utm' => collect($request->query())
                    ->filter(fn ($value, $key) => Str::startsWith(strtolower($key), 'utm_'))
                    ->all(),
            ];
            Cookie::queue(self::COOKIE_NAME, json_encode($split, JSON_UNESCAPED_UNICODE), self::COOKIE_MINUTES);
            if ($clickedOld) {
                $this->logClick($split['id'], null);
            }
        } elseif ($clickedOld && $split['variant'] !== 'old') {
            // первый переход по «Вернуться в старый дизайн»: фиксируем клик и закрепляем старый дизайн навсегда
            $this->logClick($split['id'] ?? null, $split['variant']);
            $split['variant'] = 'old';
            Cookie::queue(self::COOKIE_NAME, json_encode($split, JSON_UNESCAPED_UNICODE), self::COOKIE_MINUTES);
        }

        // ?set_old_view=1 безусловно даёт старый дизайн (config остаётся не выставлен из boot)
        if (! $clickedOld) {
            config(['is_new_desing' => $split['variant'] === 'new']);
        }

        return $next($request);
    }

    private function logClick(?string $visitorId, ?string $variantFrom): void
    {
        try {
            DesignClick::create([
                'visitor_id' => $visitorId,
                'variant_from' => $variantFrom,
            ]);
        } catch (\Throwable $e) {
            \Log::warning('design_clicks not saved', ['error' => $e->getMessage()]);
        }
    }
}
