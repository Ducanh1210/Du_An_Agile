@extends('layouts.trainer')

@section('content')
<div style="margin-bottom: 32px;">
    <a href="{{ route('trainer.students') }}" style="text-decoration: none; color: var(--text-muted); font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 24px;">
        <i class="fa-solid fa-arrow-left-long"></i> QUAY LẠI DANH SÁCH
    </a>
    
    <div class="card" style="margin-bottom: 0; padding: 32px;">
        <div style="display: flex; gap: 32px; align-items: center; flex-wrap: wrap;">
            <div style="position: relative;">
                <img src="{{ $student->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=FF6B35&color=fff' }}" 
                     style="width: 100px; height: 100px; border-radius: 32px; object-fit: cover; border: 4px solid white; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div style="position: absolute; bottom: -5px; right: -5px; width: 28px; height: 28px; background: #10B981; border: 4px solid white; border-radius: 50%;"></div>
            </div>
            <div style="flex: 1; min-width: 250px;">
                <h1 style="font-size: 32px; font-weight: 900; margin-bottom: 4px; letter-spacing: -1.5px;">{{ $student->name }}</h1>
                <p style="color: var(--text-muted); font-size: 15px; font-weight: 500; margin-bottom: 16px;">{{ $student->email }}</p>
                <div style="display: flex; gap: 12px;">
                    <span style="background: #F8FAFC; color: var(--text-main); padding: 6px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; border: 1px solid var(--border);">HIGHT: {{ $student->height ?? '??' }} CM</span>
                    <span style="background: #FFF1EB; color: var(--primary); padding: 6px 16px; border-radius: 12px; font-size: 13px; font-weight: 700; border: 1px solid rgba(255,107,53,0.1);">PHONE: {{ $student->phone ?? 'N/A' }}</span>
                </div>
            </div>
            <div style="display: flex; gap: 12px;">
                <button onclick="switchTab('progress')" id="tab-progress" class="btn btn-primary" style="padding: 12px 24px;">Tiến trình</button>
                <button onclick="switchTab('update')" id="tab-update" class="btn btn-outline" style="padding: 12px 24px;">Cập nhật chỉ số</button>
                <button onclick="switchTab('reschedule')" id="tab-reschedule" class="btn btn-outline" style="padding: 12px 24px;">Đổi lịch</button>
            </div>
        </div>
    </div>
</div>

<!-- Progress Tab -->
<div id="content-progress">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px; margin-bottom: 24px;">
        <div class="card" style="padding: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
                <div>
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 4px;">Biểu đồ cân nặng</h3>
                    <p style="color: var(--text-muted); font-size: 13px; font-weight: 500;">Theo dõi thay đổi trong 30 ngày qua</p>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 24px; font-weight: 900; color: var(--primary);">{{ end($chartData['weight']) ?? '--' }}</span>
                    <span style="font-size: 12px; font-weight: 700; color: var(--text-muted);">KG</span>
                </div>
            </div>
            <canvas id="weightChart" style="width: 100%; height: 250px;"></canvas>
        </div>

        <div class="card" style="padding: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
                <div>
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 4px;">Chỉ số BMI</h3>
                    <p style="color: var(--text-muted); font-size: 13px; font-weight: 500;">Chỉ số khối cơ thể hiện tại</p>
                </div>
                <div style="text-align: right;">
                    <span style="font-size: 24px; font-weight: 900; color: var(--secondary);">{{ end($chartData['bmi']) ?? '--' }}</span>
                    <span style="font-size: 12px; font-weight: 700; color: var(--text-muted);">BMI</span>
                </div>
            </div>
            <canvas id="bmiChart" style="width: 100%; height: 250px;"></canvas>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 24px 32px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 18px; font-weight: 800;">Lịch sử đo lường</h3>
            <button class="btn btn-outline" style="font-size: 12px; padding: 6px 12px;"><i class="fa-solid fa-download"></i> Xuất PDF</button>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #F8FAFC;">
                        <th style="padding: 16px 32px; text-align: left; font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Ngày đo</th>
                        <th style="padding: 16px 32px; text-align: left; font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Cân nặng</th>
                        <th style="padding: 16px 32px; text-align: left; font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">BMI</th>
                        <th style="padding: 16px 32px; text-align: left; font-size: 12px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->healthMetrics->reverse() as $metric)
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 20px 32px; font-weight: 700; color: var(--text-main);">{{ $metric->created_at->format('d/m/Y') }}</td>
                        <td style="padding: 20px 32px; font-weight: 900; color: var(--primary);">{{ $metric->weight }} kg</td>
                        <td style="padding: 20px 32px; font-weight: 800; color: var(--secondary);">{{ $metric->bmi }}</td>
                        <td style="padding: 20px 32px;">
                            <span style="padding: 4px 12px; background: #ECFDF5; color: #10B981; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase;">Ổn định</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 60px; text-align: center; color: var(--text-muted); font-weight: 600;">Chưa có dữ liệu lịch sử đo lường.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Update Tab -->
<div id="content-update" style="display: none;">
    <div class="card" style="max-width: 600px; margin: 0 auto; padding: 40px;">
        <h2 style="font-size: 24px; font-weight: 900; margin-bottom: 32px; letter-spacing: -1px;">Ghi nhận chỉ số mới</h2>
        <form action="{{ route('trainer.student.metrics', $student->id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Cân nặng hiện tại (kg)</label>
                <input type="number" name="weight" step="0.1" value="{{ $student->healthMetrics->last()?->weight }}" 
                       style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 16px; font-size: 16px; font-weight: 800; outline: none; background: #F8FAFC;">
            </div>
            <div style="margin-bottom: 32px;">
                <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Phần trăm mỡ cơ thể (%) - <small style="color: var(--text-muted);">Tùy chọn</small></label>
                <input type="number" name="fat_percent" step="0.1" 
                       style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 16px; font-size: 16px; font-weight: 800; outline: none; background: #F8FAFC;">
            </div>
            <div style="background: var(--primary-light); padding: 20px; border-radius: 16px; display: flex; gap: 16px; margin-bottom: 32px;">
                <i class="fa-solid fa-circle-info" style="color: var(--primary); font-size: 20px;"></i>
                <p style="font-size: 13px; color: var(--primary); font-weight: 700; line-height: 1.5;">Hệ thống sẽ tự động tính BMI dựa trên cân nặng mới và chiều cao cố định ({{ $student->height }}cm) của học viên.</p>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 15px;">LƯU THÔNG TIN ĐO LƯỜNG</button>
        </form>
    </div>
</div>

<!-- Reschedule Tab -->
<div id="content-reschedule" style="display: none;">
    <div class="card" style="max-width: 600px; margin: 0 auto; padding: 40px;">
        <h2 style="font-size: 24px; font-weight: 900; margin-bottom: 12px; letter-spacing: -1px;">Thay đổi lịch tập</h2>
        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 32px; font-weight: 500;">Gửi yêu cầu dời lịch cho các ca tập đã xác nhận.</p>
        
        <form action="{{ route('trainer.booking.reschedule', $student->bookings->where('status', 'confirmed')->first()?->id ?? 0) }}" method="POST">
            @csrf
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Thời gian bắt đầu mới</label>
                <input type="datetime-local" name="new_start_time" style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 16px; font-family: inherit; font-weight: 800; outline: none; background: #F8FAFC;">
            </div>
            <div style="margin-bottom: 32px;">
                <label style="display: block; font-size: 14px; font-weight: 800; margin-bottom: 10px;">Lý do thay đổi</label>
                <textarea name="reason" rows="3" style="width: 100%; border: 1.5px solid var(--border); border-radius: 14px; padding: 16px; font-family: inherit; font-weight: 600; outline: none; background: #F8FAFC; resize: none;" placeholder="Nhập lý do dời lịch..."></textarea>
            </div>
            
            @if($student->bookings->where('status', 'confirmed')->isEmpty())
                <div style="background: #FEF2F2; color: #DC2626; padding: 20px; border-radius: 16px; text-align: center; font-size: 14px; font-weight: 800; border: 1px solid #FEE2E2;">
                    Học viên hiện không có ca tập nào để thực hiện dời lịch.
                </div>
            @else
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 15px;">GỬI YÊU CẦU ĐỔI LỊCH</button>
            @endif
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function switchTab(tab) {
        // Hide all
        document.getElementById('content-progress').style.display = 'none';
        document.getElementById('content-update').style.display = 'none';
        document.getElementById('content-reschedule').style.display = 'none';
        
        // Reset buttons
        ['progress', 'update', 'reschedule'].forEach(t => {
            const btn = document.getElementById('tab-' + t);
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline');
        });

        // Show active
        document.getElementById('content-' + tab).style.display = 'block';
        const activeBtn = document.getElementById('tab-' + tab);
        activeBtn.classList.remove('btn-outline');
        activeBtn.classList.add('btn-primary');
    }

    // Chart.js implementation
    const commonOptions = {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { color: '#F1F5F9' }, border: { display: false } },
            x: { grid: { display: false } }
        },
        elements: {
            line: { tension: 0.4 },
            point: { radius: 6, hoverRadius: 8, backgroundColor: 'white', borderWidth: 3 }
        }
    };

    const labels = {!! json_encode($chartData['labels']) !!};

    new Chart(document.getElementById('weightChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: {!! json_encode($chartData['weight']) !!},
                borderColor: '#FF6B35',
                backgroundColor: 'rgba(255, 107, 53, 0.1)',
                fill: true
            }]
        },
        options: commonOptions
    });

    new Chart(document.getElementById('bmiChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: {!! json_encode($chartData['bmi']) !!},
                borderColor: '#2563EB',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true
            }]
        },
        options: commonOptions
    });
</script>
@endsection
