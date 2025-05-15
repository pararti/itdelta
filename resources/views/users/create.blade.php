@extends('layouts.admin')

@section('title', 'Добавить пользователя')

@section('content')
    <h1>Добавить нового пользователя</h1>

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @include('users.partials._form', ['submitButtonText' => 'Создать пользователя'])
    </form>
@endsection 