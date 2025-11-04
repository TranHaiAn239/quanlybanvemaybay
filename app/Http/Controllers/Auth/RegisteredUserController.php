<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\NguoiDung;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.NguoiDung::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ---- BẮT ĐẦU THAY ĐỔI ----
        $user = NguoiDung::create([
            'ho_ten' => $request->name, // Ánh xạ 'name' -> 'ho_ten'
            'email' => $request->email,
            'mat_khau' => Hash::make($request->password), // Ánh xạ 'password' -> 'mat_khau'
            'vai_tro' => 'khach_hang', // Mặc định khi đăng ký
            'trang_thai' => 'hoat_dong',
        ]);
        // ---- KẾT THÚC THAY ĐỔI ----

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
