@extends('layouts.admin')

@section('title', 'Список пользователей')

@section('content')
    <h1>Список пользователей</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary" style="margin-bottom: 20px;">Добавить пользователя</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Фото</th>
                <th>Логин</th>
                <th>ФИО</th>
                <th>Email</th>
                <th>Дата рождения</th>
                <th>Телефон</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        @if($user->photo_path)
                            <img src="{{ Storage::url($user->photo_path) }}" alt="Фото {{ $user->name }}" class="user-photo">
                        @else
                            Нет фото
                        @endif
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->date_of_birth ? $user->date_of_birth->format('d.m.Y') : 'N/A' }}</td>
                    <td>{{ $user->mobile_phone ?? 'N/A' }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary">Изменить</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Пользователи не найдены.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
@endsection
