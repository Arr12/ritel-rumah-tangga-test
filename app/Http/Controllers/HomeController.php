<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\BuyerLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Models\User;

class HomeController extends Controller
{
    public function cart() {
        return view('pages.cart');
    }

    public function checkout() {
        return view('pages.checkout');
    }

    public function wishlist() {
        return view('pages.wishlist');
    }

    public function profile() {
        return view('pages.profile');
    }

    public function order() {
        return view('pages.order');
    }

    public function information() {
        return view('pages.information');
    }

    public function login() {
        return view('pages.buyer.login');
    }

    public function register() {
        return view('pages.buyer.register');
    }

    public function loginRequest(BuyerLoginRequest $request) {
        $request->authenticate();
        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => 'Data Saved Successfully'
        ], 'token' => $token], 200);
    }

    public function registerPost() {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'year' => $request->year,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['meta' => [
            'status' => 'success',
            'message' => 'Data Saved Successfully'
        ]], 200);
    }
}
