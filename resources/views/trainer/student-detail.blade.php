@extends('layouts.trainer')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('trainer.students') }}" style="text-decoration: none; color: var(--text-muted); font-size: 14px; display: flex; align-items: center; gap: 6px; margin-bottom: 16px;">
        <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>
    <div style="display: flex; gap: 20px; align-items: center;">
        <img src="{{ $student->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=FF6B35&color=fff' }}" 
             style="width: 80px; height: 80px; border-radius: 20px; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
        <div>
            <h1 style="font-size: 22px; font-weight: 800; margin-bottom: 4px;">{{ $student->name }}</h1>
            <p style="color: var(--text-muted); font-size: 14px;">{{ $student->email }}</p>
            <div style="display: flex; gap: 8px; margin-top: 8px;">
                <span class="badge badge-primary">{{ $student->height ?? '??' }} cm</span>
                <span class="badge badge-success">{{ $student->phone ?? 'Chưa có SĐT' }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Tabs (Simple JS Toggle) -->
<div style="display: flex; gap: 10px; margin-bottom: 20px; overflow-x: auto; padding-bottom: 4px;">
    <button onclick="switchTab('progress')" id="tab-progress" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px; width: auto; white-space: nowrap;">Tiến độ (Biểu đồ)</button>
    <button onclick="switchTab('plan')" id="tab-plan" class="btn btn-outline" style="padding: 8px 16px; font-size: 13px; width: auto; white-space: nowrap;">Giáo án tập luyện</button>
    <button onclick="switchTab('update')" id="tab-update" class="btn btn-outline" style="padding: 8px 16px; font-size: 13px; width: auto; white-space: nowrap;">Cập nhật chỉ số</button>
    <button onclick="switchTab('reschedule')" id="tab-reschedule" class="btn btn-outline" style="padding: 8px 16px; font-size: 13px; width: auto; white-space: nowrap; border-color: #64748B; color: #64748B;">Đổi lịch</button>
</div>

<!-- Progress Tab -->
<div id="content-progress">
    <div class="card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Biểu đồ Cân nặng (30 ngày)</h3>
        <canvas id="weightChart" style="width: 100%; height: 200px;"></canvas>
    </div>

    <div class="card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Biểu đồ BMI (30 ngày)</h3>
        <canvas id="bmiChart" style="width: 100%; height: 200px;"></canvas>
    </div>

    <div class="card" style="padding: 0; overflow: hidden;">
        <div style="padding: 16px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700;">Lịch sử chỉ số</h3>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background: #F8FAFC;">
                    <tr>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid var(--border);">Ngày</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid var(--border);">Cân nặng</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid var(--border);">BMI</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 1px solid var(--border);">Người nhập</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($student->healthMetrics->reverse() as $metric)
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border);">{{ $metric->created_at->format('d/m') }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border); font-weight: 600;">{{ $metric->weight }}kg</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border);">{{ $metric->bmi }}</td>
                        <td style="padding: 12px; border-bottom: 1px solid var(--border);">
                            <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: {{ $metric->recorded_by == 'trainer' ? 'var(--primary)' : 'var(--secondary)' }}">
                                {{ $metric->recorded_by }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 30px; text-align: center; color: var(--text-muted);">Chưa có dữ liệu chỉ số.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Training Plan Tab -->
<div id="content-plan" style="display: none;">
    <div class="card">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Tạo giáo án mới</h3>
        <form action="{{ route('trainer.student.training_plan.store', $student->id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Tiêu đề giáo án</label>
                <input type="text" name="title" placeholder="VD: Giáo án tuần 1 - Giảm mỡ" 
                       style="width: 100%; border: 1.5px solid var(--border); border-radius: 12px; padding: 12px; font-size: 16px; outline: none;" required>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Nội dung bài tập</label>
                <textarea name="content" rows="6" placeholder="Nhập chi tiết các bài tập, số hiệp, số lần..." 
                          style="width: 100%; border: 1.5px solid var(--border); border-radius: 12px; padding: 12px; font-size: 15px; outline: none; font-family: inherit;" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Lưu giáo án</button>
        </form>
    </div>

    <div style="margin-top: 24px;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Lịch sử giáo án</h3>
        @forelse($student->trainingPlans as $plan)
            <div class="card" style="margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <h4 style="font-size: 16px; font-weight: 700; color: var(--primary);">{{ $plan->title }}</h4>
                    <span style="font-size: 12px; color: var(--text-muted);">{{ $plan->created_at->format('d/m/Y') }}</span>
                </div>
                <div style="font-size: 14px; color: var(--text-main); white-space: pre-line; line-height: 1.6;">{{ $plan->content }}</div>
            </div>
        @empty
            <div class="card" style="text-align: center; padding: 30px;">
                <p style="color: var(--text-muted); font-size: 14px;">Chưa có giáo án nào được tạo.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Update Metrics Tab -->
<div id="content-update" style="display: none;">
    <div class="card">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Cập nhật chỉ số mới</h3>
        <form action="{{ route('trainer.student.metrics', $student->id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Cân nặng (kg)</label>
                <input type="number" name="weight" step="0.1" value="{{ $student->healthMetrics->last() ? $student->healthMetrics->last()->weight : '' }}" 
                       style="width: 100%; border: 1.5px solid var(--border); border-radius: 12px; padding: 12px; font-size: 16px; outline: none;" required>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Phần trăm mỡ (%) - Không bắt buộc</label>
                <input type="number" name="fat_percent" step="0.1" style="width: 100%; border: 1.5px solid var(--border); border-radius: 12px; padding: 12px; font-size: 16px; outline: none;">
            </div>
            <div style="padding: 12px; background: #FFF1EB; border-radius: 12px; margin-bottom: 20px;">
                <p style="font-size: 12px; color: var(--primary-dark); line-height: 1.4;">
                    <i class="fa-solid fa-circle-info"></i> Hệ thống sẽ tự động tính toán <strong>BMI</strong> dựa trên chiều cao <strong>{{ $student->height }}cm</strong> của học viên.
                </p>
            </div>
            <button type="submit" class="btn btn-primary">Lưu chỉ số mới</button>
        </form>
    </div>
</div>

<!-- Reschedule Tab -->
<div id="content-reschedule" style="display: none;">
    <div class="card">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Yêu cầu đổi lịch</h3>
        <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 20px;">Vui lòng chọn buổi tập muốn đổi và nhập thời gian mới. Học viên cần phê duyệt yêu cầu này.</p>
        
        <form action="{{ route('trainer.booking.reschedule', $student->bookings->where('status', 'confirmed')->first()?->id ?? 0) }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Thời gian bắt đầu mới</label>
                <input type="datetime-local" name="new_start_time" style="width: 100%; border: 1.5px solid var(--border); border-radius: 12px; padding: 12px; font-size: 15px; font-family: inherit;" required>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Lý do thay đổi</label>
                <textarea name="reason" rows="3" style="width: 100%; border: 1.5px solid var(--border); border-radius: 12px; padding: 12px; outline: none;" placeholder="Ví dụ: Trainer có việc bận đột xuất..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" {{ $student->bookings->where('status', 'confirmed')->isEmpty() ? 'disabled' : '' }}>
                Gửi yêu cầu đổi lịch
            </button>
            @if($student->bookings->where('status', 'confirmed')->isEmpty())
                <p style="font-size: 12px; color: #DC2626; margin-top: 8px; text-align: center;">Học viên này hiện không có buổi tập nào sắp tới.</p>
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
        document.getElementById('content-plan').style.display = 'none';
        document.getElementById('content-update').style.display = 'none';
        document.getElementById('content-reschedule').style.display = 'none';
        
        // Reset buttons
        ['progress', 'plan', 'update', 'reschedule'].forEach(t => {
            const btn = document.getElementById('tab-' + t);
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline');
            btn.style.borderColor = (t === 'reschedule') ? '#64748B' : '';
            btn.style.color = (t === 'reschedule') ? '#64748B' : '';
        });

        // Show active
        document.getElementById('content-' + tab).style.display = 'block';
        const activeBtn = document.getElementById('tab-' + tab);
        activeBtn.classList.remove('btn-outline');
        activeBtn.classList.add('btn-primary');
        activeBtn.style.color = 'white';
        activeBtn.style.borderColor = 'var(--primary)';
    }

    // Chart.js implementation
    const ctxWeight = document.getElementById('weightChart').getContext('2d');
    const ctxBmi = document.getElementById('bmiChart').getContext('2d');
    
    const chartLabels = {!! json_encode($chartData['labels']) !!};
    const weightData = {!! json_encode($chartData['weight']) !!};
    const bmiData = {!! json_encode($chartData['bmi']) !!};

    const commonOptions = {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: false, grid: { color: '#F1F5F9' } },
            x: { grid: { display: false } }
        },
        elements: {
            line: { tension: 0.4 },
            point: { radius: 4, backgroundColor: 'white', borderWidth: 2 }
        }
    };

    new Chart(ctxWeight, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                data: weightData,
                borderColor: '#FF6B35',
                borderWidth: 3,
                fill: true,
                backgroundColor: 'rgba(255, 107, 53, 0.1)'
            }]
        },
        options: commonOptions
    });

    new Chart(ctxBmi, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                data: bmiData,
                borderColor: '#2563EB',
                borderWidth: 3,
                fill: true,
                backgroundColor: 'rgba(37, 99, 235, 0.1)'
            }]
        },
        options: commonOptions
    });
</script>
@endsection
