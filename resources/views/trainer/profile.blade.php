@extends('layouts.trainer')

@section('content')
<div class="card mb-4">
    <h3 style="margin-bottom: 16px; font-size: 18px; color: var(--text-main);">Hồ sơ cá nhân</h3>
    
    <form action="{{ route('trainer.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="text-align: center; margin-bottom: 24px;">
            <div style="position: relative; display: inline-block;">
                <img id="avatar-preview" 
                     src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=FF6B35&color=fff' }}" 
                     alt="Avatar" 
                     style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <label for="avatar" style="position: absolute; bottom: 0; right: 0; background: var(--primary); color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    <i class="fa-solid fa-camera" style="font-size: 14px;"></i>
                </label>
                <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;" onchange="previewImage(this)">
            </div>
            @error('avatar')
                <div style="color: #ef4444; font-size: 12px; margin-top: 8px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: var(--text-muted); margin-bottom: 8px;">Họ và tên</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); font-family: inherit; font-size: 15px; outline: none; transition: border-color 0.2s;">
            @error('name')
                <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>



        <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: var(--text-muted); margin-bottom: 8px;">Chuyên môn</label>
            <input type="text" name="specialization" value="{{ old('specialization', $trainer->specialization) }}" required
                   style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); font-family: inherit; font-size: 15px; outline: none; transition: border-color 0.2s;"
                   placeholder="VD: Giảm cân, Tăng cơ, Yoga...">
            @error('specialization')
                <div style="color: #ef4444; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 8px;">
            <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
