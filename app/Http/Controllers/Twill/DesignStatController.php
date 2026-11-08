<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Http\Controllers\Admin\Controller;
use App\Models\DesignClick;
use App\Models\DesignOrderStat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DesignStatController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        $ordersQuery = DesignOrderStat::query()
            ->whereBetween('design_order_stats.created_at', [$startDate, Carbon::parse($endDate)->endOfDay()]);

        $ordersByDesign = (clone $ordersQuery)
            ->selectRaw('design, count(*) as orders_count')
            ->groupBy('design')
            ->pluck('orders_count', 'design');

        $revenueByDesign = (clone $ordersQuery)
            ->join('orders', 'orders.id', '=', 'design_order_stats.order_id')
            ->selectRaw('design, sum(orders.total_price) as revenue')
            ->groupBy('design')
            ->pluck('revenue', 'design');

        $orders = (clone $ordersQuery)
            ->join('orders', 'orders.id', '=', 'design_order_stats.order_id')
            ->orderByDesc('design_order_stats.created_at')
            ->select('design_order_stats.*', 'orders.num_order')
            ->paginate(25)
            ->appends($request->query());

        $clicksQuery = DesignClick::query()
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()]);

        $clicks = (clone $clicksQuery)
            ->orderByDesc('created_at')
            ->paginate(25)
            ->appends($request->query());

        return view('twill.stats.design', [
            'stats' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'new_orders' => $ordersByDesign->get('new', 0),
                'old_orders' => $ordersByDesign->get('old', 0),
                'new_revenue' => $revenueByDesign->get('new', 0) ?? 0,
                'old_revenue' => $revenueByDesign->get('old', 0) ?? 0,
                'clicks' => (clone $clicksQuery)->count(),
                'click_visitors' => (clone $clicksQuery)->distinct()->count('visitor_id'),
            ],
            'orders' => $orders,
            'clicks' => $clicks,
        ]);
    }
}
