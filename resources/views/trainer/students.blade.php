@extends('layouts.trainer')

@section('content')
<div class="header-section" style="margin-bottom: 24px;">
    <h1 style="font-size: 24px; font-weight: 800;">Danh sách học viên</h1>
    <p style="color: var(--text-muted); font-size: 15px;">Quản lý và theo dõi tiến độ của {{ $students->count() }} học viên.</p>
</div>

<!-- Search (UI Only for now) -->
<div class="card" style="padding: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
    <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
    <input type="text" placeholder="Tìm tên học viên..." style="border: none; outline: none; width: 100%; font-size: 15px;">
</div>

@if($students->isEmpty())
    <div class="card" style="text-align: center; padding: 40px 20px;">
        <i class="fa-solid fa-users-slash" style="font-size: 40px; color: var(--border); margin-bottom: 16px;"></i>
        <p style="color: var(--text-muted);">Bạn chưa được phân công học viên nào.</p>
    </div>
@else
    <div style="display: grid; gap: 12px;">
        @foreach($students as $student)
        <a href="{{ route('trainer.student.detail', $student->id) }}" class="card" style="text-decoration: none; color: inherit; display: flex; align-items: center; justify-content: space-between; transition: transform 0.2s;">
            <div style="display: flex; gap: 16px; align-items: center;">
                <img src="{{ $student->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=FF6B35&color=fff' }}" 
                     style="width: 56px; height: 56px; border-radius: 16px; object-fit: cover;">
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">{{ $student->name }}</h3>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span class="badge badge-blue">{{ $student->height ? $student->height . 'cm' : 'Chưa nhập cao' }}</span>
                        @if($student->healthMetrics->last())
                            <span class="badge badge-primary">{{ $student->healthMetrics->last()->weight }}kg</span>
                        @endif
                    </div>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right" style="color: var(--border); font-size: 14px;"></i>
        </a>
        @endforeach
    </div>
@endif

<style>
    .card:active {
        transform: scale(0.98);
        background-color: #FAFAFA;
    }
</style>
@endsection
