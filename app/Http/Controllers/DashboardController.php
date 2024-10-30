<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.check');
    }
    public function index()
    {
        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/bantuan', []);
        $response_body = json_decode($response->getBody());
        $bantuan = $response_body->data->data;

        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/penduduk', []);
        $response_body = json_decode($response->getBody());
        $penduduk = $response_body->data->data;

        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/barang', []);
        $response_body = json_decode($response->getBody());
        $barang = $response_body->data->data;

        return view('home', compact('bantuan', 'penduduk', 'barang'));
    }
}
