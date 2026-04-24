<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Báo cáo Doanh thu - EXTRA FIT+</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ea580c;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #ea580c;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #1e293b;
            border-left: 4px solid #ea580c;
            padding-left: 10px;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 20px;
        }
        .stats-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .stats-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 5px;
        }
        .stats-value {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
        }
        .text-right { text-align: right; }
        .text-emerald { color: #059669; }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BÁO CÁO DOANH THU</h1>
        <p>Hệ thống Quản lý Phòng tập EXTRA FIT+</p>
        <p>Ngày xuất: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="section-title">Tổng quan tài chính</div>
    <table class="stats-grid">
        <tr>
            <td class="stats-box">
                <div class="stats-label">Tổng doanh thu</div>
                <div class="stats-value text-emerald">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
            </td>
            <td class="stats-box">
                <div class="stats-label">Tháng hiện tại</div>
                <div class="stats-value">{{ number_format($currentMonthRevenue, 0, ',', '.') }}đ</div>
            </td>
            <td class="stats-box">
                <div class="stats-label">Tỷ lệ tăng trưởng</div>
                <div class="stats-value {{ $growthRate >= 0 ? 'text-emerald' : 'text-red-500' }}">
                    {{ $growthRate > 0 ? '+' : '' }}{{ number_format($growthRate, 1) }}%
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Doanh thu theo tháng (Năm {{ date('Y') }})</div>
    <table>
        <thead>
            <tr>
                <th>Tháng</th>
                @foreach(['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'] as $m)
                    <th class="text-right">{{ $m }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Doanh thu</td>
                @foreach($monthlyRevenue as $val)
                    <td class="text-right">{{ number_format($val/1000000, 1) }}M</td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <div class="section-title">Top 5 Gói tập phổ biến</div>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên gói tập</th>
                <th>Danh mục</th>
                <th class="text-right">Số lượt bán</th>
                <th class="text-right">Doanh thu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topPackages as $index => $pkg)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pkg->name }}</td>
                <td>{{ $pkg->category }}</td>
                <td class="text-right">{{ $pkg->total_sales }}</td>
                <td class="text-right font-bold text-emerald">{{ number_format($pkg->total_revenue, 0, ',', '.') }}đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Phân bổ doanh thu theo môn tập</div>
    <table>
        <thead>
            <tr>
                <th>Môn tập</th>
                <th class="text-right">Doanh thu</th>
                <th class="text-right">Tỷ lệ</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalCat = $categoryData['gym'] + $categoryData['yoga'];
            @endphp
            <tr>
                <td>Gym</td>
                <td class="text-right">{{ number_format($categoryData['gym'], 0, ',', '.') }}đ</td>
                <td class="text-right">{{ $totalCat > 0 ? number_format(($categoryData['gym'] / $totalCat) * 100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td>Yoga</td>
                <td class="text-right">{{ number_format($categoryData['yoga'], 0, ',', '.') }}đ</td>
                <td class="text-right">{{ $totalCat > 0 ? number_format(($categoryData['yoga'] / $totalCat) * 100, 1) : 0 }}%</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Báo cáo được tạo tự động bởi hệ thống Extra Fit+ &bull; {{ url('/') }}
    </div>
</body>
</html>
