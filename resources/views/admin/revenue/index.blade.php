@extends('layouts.admin')

@section('title', 'Báo cáo Doanh thu & Thống kê')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Thống kê Doanh thu</h2>
        <p class="text-slate-500 text-sm mt-1">Tổng quan tài chính và hoạt động bán hàng</p>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.revenue.export_pdf') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-all text-sm font-semibold shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-file-pdf"></i> Xuất PDF
        </a>
        <button onclick="window.print()" class="px-4 py-2 bg-white border border-gray-200 text-slate-700 rounded-xl hover:bg-gray-50 hover:text-primary transition-all text-sm font-semibold shadow-sm flex items-center gap-2">
            <i class="fa-solid fa-print"></i> In báo cáo
        </button>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 uppercase tracking-tighter">
    
    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5">Tổng Doanh Thu</div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight leading-loose text-emerald-600">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
        </div>
        <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-coins"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5">Doanh thu tháng này</div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight leading-loose text-blue-600">{{ number_format($currentMonthRevenue, 0, ',', '.') }}đ</div>
        </div>
        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5">Lượt GD Thành công</div>
            <div class="text-3xl font-bold text-slate-900 tracking-tight leading-loose text-orange-600">{{ $successfulTransactionsCount }} / {{ $totalTransactionsCount }}</div>
        </div>
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
            <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>
    </div>

    <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-xl transition-all duration-300">
        <div>
            <div class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1.5">Tỷ lệ tăng trưởng (Tháng)</div>
            <div class="text-3xl font-bold tracking-tight leading-loose {{ $growthRate >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $growthRate > 0 ? '+' : '' }}{{ number_format($growthRate, 1) }}%
            </div>
        </div>
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl transition-colors duration-300 {{ $growthRate >= 0 ? 'bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white' : 'bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white' }}">
            <i class="fa-solid {{ $growthRate >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
        </div>
    </div>
</div>

<!-- Charts Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Monthly Revenue Chart -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 tracking-tight"><i class="fa-regular fa-chart-bar text-primary mr-2"></i>Doanh thu theo Tháng (Năm nay)</h3>
        <div class="relative h-72">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Category Doughnut Chart -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 tracking-tight"><i class="fa-solid fa-chart-pie text-secondary mr-2"></i>Phân bổ Môn tập</h3>
        <div class="relative h-64 flex items-center justify-center">
            <canvas id="categoryChart"></canvas>
        </div>
        <div class="mt-4 flex justify-center gap-6 text-sm font-medium">
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-orange-500"></span>Gym</div>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-purple-500"></span>Yoga</div>
        </div>
    </div>

    <!-- Weekly Revenue Chart -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 tracking-tight"><i class="fa-solid fa-chart-line text-blue-500 mr-2"></i>Doanh thu 4 tuần gần nhất</h3>
        <div class="relative h-64">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    <!-- Top Packages -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 tracking-tight"><i class="fa-solid fa-award text-yellow-500 mr-2"></i>Top Gói Tập Tốt Nhất</h3>
        <div class="space-y-4">
            @forelse($topPackages as $index => $pkg)
                <div class="flex items-center justify-between p-3 rounded-2xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $index == 0 ? 'bg-yellow-100 text-yellow-600' : ($index == 1 ? 'bg-slate-100 text-slate-600' : ($index == 2 ? 'bg-orange-100 text-orange-800' : 'bg-gray-50 text-gray-400')) }}">
                            #{{ $index + 1 }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">{{ $pkg->name }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">{{ $pkg->category }} &bull; {{ $pkg->total_sales }} lượt đk</p>
                        </div>
                    </div>
                    <div class="text-sm font-bold text-emerald-600">
                        {{ number_format($pkg->total_revenue, 0, ',', '.') }}đ
                    </div>
                </div>
            @empty
                <div class="text-center text-slate-400 py-6 text-sm">Chưa có dữ liệu giao dịch</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Chart.js inclusion -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shared options
        const defaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        };

        // 1. Monthly Chart
        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: {!! json_encode($monthlyRevenue) !!},
                    backgroundColor: '#ea580c', // Orange 600
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                ...defaultOptions,
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Weekly Chart
        const ctxWeekly = document.getElementById('weeklyChart').getContext('2d');
        new Chart(ctxWeekly, {
            type: 'line',
            data: {
                labels: {!! json_encode($weeklyLabels) !!},
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: {!! json_encode($weeklyRevenue) !!},
                    borderColor: '#3b82f6', // Blue 500
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                }]
            },
            options: {
                ...defaultOptions,
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [4, 4] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 3. Category Doughnut Chart
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: ['Gym', 'Yoga'],
                datasets: [{
                    data: [{{ $categoryData['gym'] ?? 0 }}, {{ $categoryData['yoga'] ?? 0 }}],
                    backgroundColor: ['#ea580c', '#a855f7'], // Orange 500, Purple 500
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection
