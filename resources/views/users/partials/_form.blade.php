@csrf
<div class="form-group">
    <label for="name">Логин:</label>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="full_name">ФИО:</label>
    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name ?? '') }}" required>
    @error('full_name')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="date_of_birth">Дата рождения:</label>
    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', isset($user) && $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}">
    @error('date_of_birth')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="mobile_phone">Мобильный телефон:</label>
    <input type="text" id="mobile_phone" name="mobile_phone" value="{{ old('mobile_phone', $user->mobile_phone ?? '') }}">
    @error('mobile_phone')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="password">Пароль{{ isset($user) ? ' (оставьте пустым, чтобы не менять)' : '' }}:</label>
    <input type="password" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
    @error('password')
        <div class="error-message">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="password_confirmation">Подтверждение пароля:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
</div>
<div class="form-group">
    <label for="photo">Фото:</label>
    <input type="file" id="photo" name="photo">
    @error('photo')
        <div class="error-message">{{ $message }}</div>
    @enderror
    @if(isset($user) && $user->photo_path)
        <div style="margin-top: 10px;">
            <p>Текущее фото:</p>
            <img src="{{ Storage::url($user->photo_path) }}" alt="Фото {{ $user->name }}" class="user-photo">
        </div>
    @endif
</div>

<button type="submit" class="btn btn-primary">{{ $submitButtonText ?? 'Сохранить' }}</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Отмена</a>
