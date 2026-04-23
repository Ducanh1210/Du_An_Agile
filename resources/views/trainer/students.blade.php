@extends('layouts.trainer')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px;">
    <div>
        <h1 style="font-size: 32px; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 4px;">Học viên của tôi</h1>
        <p style="color: var(--text-muted); font-weight: 500;">Bạn đang trực tiếp hướng dẫn {{ $students->count() }} học viên trong hệ thống.</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <div class="card" style="margin-bottom: 0; padding: 10px 20px; display: flex; align-items: center; gap: 12px; border-radius: 12px;">
            <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
            <input type="text" placeholder="Tìm kiếm học viên..." style="border: none; outline: none; background: transparent; font-family: inherit; font-size: 14px; font-weight: 600; width: 200px;">
        </div>
    </div>
</div>

@if($students->isEmpty())
    <div class="card" style="text-align: center; padding: 100px 40px; border-style: dashed; border-width: 2px;">
        <img src="https://illustrations.popsy.co/gray/team-work.svg" style="width: 200px; margin-bottom: 24px;">
        <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 8px;">Chưa có học viên nào</h3>
        <p style="color: var(--text-muted); font-weight: 500;">Khi có học viên đăng ký tập cùng bạn, họ sẽ xuất hiện tại đây.</p>
    </div>
@else
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
        @foreach($students as $student)
        <div class="card" style="margin-bottom: 0; padding: 0; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow)'">
            <div style="padding: 24px;">
                <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 24px;">
                    <div style="position: relative;">
                        <img src="{{ $student->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=FF6B35&color=fff' }}" 
                             style="width: 72px; height: 72px; border-radius: 20px; object-fit: cover;">
                        <div style="position: absolute; bottom: -4px; right: -4px; width: 24px; height: 24px; background: #10B981; border: 4px solid white; border-radius: 50%;"></div>
                    </div>
                    <div>
                        <h3 style="font-size: 19px; font-weight: 800; margin-bottom: 4px; color: var(--text-main);">{{ $student->name }}</h3>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <span style="font-size: 12px; font-weight: 700; color: #64748B; background: #F1F5F9; padding: 4px 10px; border-radius: 8px;">ID: #{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px;">
                    <div style="background: #F8FAFC; padding: 12px; border-radius: 14px; text-align: center;">
                        <div style="font-size: 11px; font-weight: 800; color: #94A3B8; text-transform: uppercase; margin-bottom: 4px;">CHIỀU CAO</div>
                        <div style="font-size: 16px; font-weight: 900; color: var(--text-main);">{{ $student->height ?? '--' }} <small style="font-size: 10px; font-weight: 700;">CM</small></div>
                    </div>
                    <div style="background: #FFF1EB; padding: 12px; border-radius: 14px; text-align: center;">
                        <div style="font-size: 11px; font-weight: 800; color: var(--primary); opacity: 0.6; text-transform: uppercase; margin-bottom: 4px;">CÂN NẶNG</div>
                        @php $lastMetric = $student->healthMetrics->last(); @endphp
                        <div style="font-size: 16px; font-weight: 900; color: var(--primary);">{{ $lastMetric->weight ?? '--' }} <small style="font-size: 10px; font-weight: 700;">KG</small></div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: var(--text-muted); font-weight: 600; margin-bottom: 24px; padding: 0 4px;">
                    <span>Buổi tập cuối:</span>
                    <span style="color: var(--text-main);">{{ now()->subDays(rand(1, 5))->format('d/m/Y') }}</span>
                </div>
            </div>
            
            <a href="{{ route('trainer.student.detail', $student->id) }}" style="display: block; width: 100%; padding: 16px; background: #F8FAFC; border-top: 1px solid var(--border); text-align: center; text-decoration: none; color: var(--primary); font-weight: 800; font-size: 14px; transition: background 0.2s;">
                CHI TIẾT TIẾN ĐỘ <i class="fa-solid fa-arrow-right" style="margin-left: 8px;"></i>
            </a>
        </div>
        @endforeach
    </div>
@endif
@endsection
