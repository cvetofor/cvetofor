<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\Controller;
use App\Models\Market;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class StatController extends Controller {
    public function index(Request $request) {
        $startDate = $request->input('start_date', Carbon::now()->subDays(31)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $marketId = $request->input('market_id');

        $ordersQuery = Order::query()
            ->where('order_status_id', 4) // Статус "Выполнен"
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()]);

        if ($marketId && $marketId !== 'all') {
            $ordersQuery->where('market_id', $marketId);
        }

        $orders = $ordersQuery->get();

        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();

        $bouquetsStats = [];

        foreach ($orders as $order) {
            if (empty($order->cart)) {
                continue;
            }

            foreach ($order->cart as $item) {
                $id = $item['name'];
                if (!isset($bouquetsStats[$id])) {
                    $bouquetsStats[$id] = [
                        'title' => $item['name'],
                        'total_quantity' => 0,
                        'total_revenue' => 0,
                    ];
                }
                $bouquetsStats[$id]['total_quantity'] += $item['quantity'];
                $bouquetsStats[$id]['total_revenue'] += $item['price'] * $item['quantity'];
            }
        }

        arsort($bouquetsStats);

        // --- Pagination Logic ---
        $perPage = 25;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $bouquetsCollection = new Collection($bouquetsStats);
        $currentPageItems = $bouquetsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedBouquets = new LengthAwarePaginator($currentPageItems, count($bouquetsCollection), $perPage);
        $paginatedBouquets->withPath($request->url())->withQueryString();
        // --- End Pagination Logic ---

        $markets = Market::published()->get();

        $stats = [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'bouquets_stats' => $paginatedBouquets,
            'markets' => $markets,
            'selected_market_id' => $marketId
        ];

        return view('twill.stats.index', [
            'stats' => $stats,
        ]);
    }
}
