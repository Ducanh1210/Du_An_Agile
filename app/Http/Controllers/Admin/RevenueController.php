<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueController extends Controller
{
    /**
     * Màn hình báo cáo doanh thu tài chính
     */
    public function index()
    {
        // 1. Tổng doanh thu (Chỉ tính các đơn status = completed)
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        
        // 2. Tổng giao dịch thành công vs tổng giao dịch
        $totalTransactionsCount = Payment::count();
        $successfulTransactionsCount = Payment::where('status', 'completed')->count();
        
        // 3. Tính tỷ lệ tăng trưởng (Revenue tháng này so với tháng trước)
        $currentMonthRevenue = Payment::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');

        $lastMonthRevenue = Payment::where('status', 'completed')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('amount');
            
        $growthRate = 0;
        if ($lastMonthRevenue > 0) {
            $growthRate = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } elseif ($currentMonthRevenue > 0) {
            $growthRate = 100;
        }

        // 4. Doanh thu theo tháng trong năm nay
        $monthlyRevenueRaw = Payment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[] = isset($monthlyRevenueRaw[$i]) ? $monthlyRevenueRaw[$i]['total'] : 0;
        }

        // 5. Doanh thu theo tuần (4 tuần gần nhất)
        $weeklyRevenue = [];
        $weeklyLabels = [];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
            
            $weekTotal = Payment::where('status', 'completed')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->sum('amount');
                
            $weeklyRevenue[] = $weekTotal;
            $weeklyLabels[] = $startOfWeek->format('d/m') . ' - ' . $endOfWeek->format('d/m');
        }

        // 6. Doanh thu theo danh mục (Gym vs Yoga)
        $categoryRevenueRaw = DB::table('payments')
            ->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
            ->join('memberships', 'subscriptions.membership_id', '=', 'memberships.id')
            ->where('payments.status', 'completed')
            ->select('memberships.category', DB::raw('SUM(payments.amount) as total'))
            ->groupBy('memberships.category')
            ->get();
            
        $categoryData = [
            'gym' => 0,
            'yoga' => 0
        ];
        foreach ($categoryRevenueRaw as $row) {
            $categoryData[$row->category] = $row->total;
        }

        // 7. Top 5 gói tập có doanh thu cao nhất
        $topPackages = DB::table('payments')
            ->join('subscriptions', 'payments.subscription_id', '=', 'subscriptions.id')
            ->join('memberships', 'subscriptions.membership_id', '=', 'memberships.id')
            ->where('payments.status', 'completed')
            ->select('memberships.name', 'memberships.category', DB::raw('SUM(payments.amount) as total_revenue'), DB::raw('COUNT(payments.id) as total_sales'))
            ->groupBy('memberships.id', 'memberships.name', 'memberships.category')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        return view('admin.revenue.index', compact(
            'totalRevenue', 'totalTransactionsCount', 'successfulTransactionsCount', 
            'currentMonthRevenue', 'growthRate', 
            'monthlyRevenue', 'weeklyRevenue', 'weeklyLabels',
            'categoryData', 'topPackages'
        ));
    }
}
