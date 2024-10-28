<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }
    public function auth(Request $request)
    {
        $response = Http::post(env('API_URL') . 'api/authenticate', [
            'email_or_username' => $request->email_or_username,
            'password' => $request->password,
        ]);

        // dd($response->body());

        $response_body = json_decode($response->getBody());

        if ($response->ok()) {

            session(['jwt_token' => $response_body->data->token]);
            session(['name' => $response_body->data->user->name]);

            return redirect()->route('view-dashboard');
        }

        return redirect()->route('view-login')->withErrors($response->json()['message'])->withInput();
    }

    public function logout()
    {

        session()->forget('jwt_token');

        return redirect()->route('view-login');
    }
}
