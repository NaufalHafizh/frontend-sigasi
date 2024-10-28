<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PendudukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.check');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/penduduk', []);
        $response_body = json_decode($response->getBody());
        $data = $response_body->data->data;

        return view('penduduk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/kelompok', []);
        $response_body = json_decode($response->getBody());
        $kelompoks = $response_body->data->data;

        return view('penduduk.create', compact('kelompoks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Http::withToken(session('jwt_token'))->post(env('API_URL') . 'api/penduduk/store', $request->all());

        if ($response->created()) {

            return redirect()->route('kelompok.index')->with('success', "Penduduk Berhasil Dibuat");
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/penduduk/show/' . $id, []);
        $response_body = json_decode($response->getBody());
        $penduduk = $response_body->data;

        return view('penduduk.view', compact('penduduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/penduduk/show/' . $id, []);
        $response_body = json_decode($response->getBody());
        $penduduk = $response_body->data;

        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/kelompok', []);
        $response_body = json_decode($response->getBody());
        $kelompoks = $response_body->data->data;

        return view('penduduk.edit', compact('penduduk', 'kelompoks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = Http::withToken(session('jwt_token'))->post(env('API_URL') . 'api/penduduk/update/' . $id, $request->all());

        if ($response->ok()) {

            return redirect()->route('penduduk.index')->with('success', "Penduduk Berhasil Dirubah");
        }

        return redirect()->route('penduduk.index')->with('failed', "Penduduk Gagal Dirubah");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = Http::withToken(session('jwt_token'))->delete(env('API_URL') . 'api/penduduk/delete/' . $id, []);

        if ($response->ok()) {

            return redirect()->route('penduduk.index')->with('success', "Penduduk Berhasil Dihapus");
        }

        return redirect()->route('penduduk.index')->with('failed', "Penduduk Gagal Dihapus");
    }
}
