@extends('layouts.admin')

@section('title', 'Редактировать пользователя: ' . $user->name)

@section('content')
    <h1>Редактировать пользователя: {{ $user->full_name }}</h1>
    <p><strong>Логин:</strong> {{ $user->name }}</p>

    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @include('users.partials._form', ['user' => $user, 'submitButtonText' => 'Сохранить изменения'])
    </form>
@endsection 