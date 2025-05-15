<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10); // Получаем пользователей с пагинацией
        return view('users.index', compact('users'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function create()
    {
        return view('users.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Валидация входящих данных
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users', // Логин
            'full_name' => 'required|string|max:255', // ФИО
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'mobile_phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)], // Пароль (с подтверждением)
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userData = $validatedData;
        $userData['password'] = Hash::make($validatedData['password']);

        // Обработка загрузки фото
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public'); // Сохраняем в storage/app/public/photos
            $userData['photo_path'] = $path;
        }

        User::create($userData);

        return redirect()->route('users.index')->with('success', 'Пользователь успешно создан.');
    }


    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(User $user)
    {
        // Обычно для API или если карточка пользователя отличается от формы редактирования
        // return view('users.show', compact('user'));
        return redirect()->route('users.edit', $user);
    }


    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        // Валидация входящих данных
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id, // Логин (уникальный, исключая текущего пользователя)
            'full_name' => 'required|string|max:255', // ФИО
            'date_of_birth' => 'nullable|date|before_or_equal:today',
            'mobile_phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Email (уникальный, исключая текущего)
            'password' => ['nullable', 'confirmed', Password::min(8)], // Пароль (необязательный, с подтверждением)
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Фото
        ]);

        $userData = $validatedData;

        // Обновление пароля, если он предоставлен
        if (!empty($validatedData['password'])) {
            $userData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($userData['password']); // Не обновлять пароль, если поле пустое
        }

        // Обработка загрузки нового фото
        if ($request->hasFile('photo')) {
            // Удаляем старое фото, если оно есть
            if ($user->photo_path) {
                Storage::disk('public')->delete($user->photo_path);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $userData['photo_path'] = $path;
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'Данные пользователя успешно обновлены.');
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Удаляем фото пользователя, если оно есть
        if ($user->photo_path) {
            Storage::disk('public')->delete($user->photo_path);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Пользователь успешно удален.');
    }
}
