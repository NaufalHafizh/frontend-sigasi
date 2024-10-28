<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BarangController extends Controller
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
        $response =  Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/barang', []);
        $response_body = json_decode($response->getBody());
        $data = $response_body->data->data;

        return view('barang.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $response = Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/jenis-barang', []);
        $response_body = json_decode($response->getBody());
        $jenis_barangs = $response_body->data->data;

        return view('barang.create', compact('jenis_barangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = Http::withToken(session('jwt_token'))->post(env('API_URL') . 'api/barang/store', $request->all());

        if ($response->created()) {

            return redirect()->route('barang.index');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/barang/show/' . $id, []);
        $response_body = json_decode($response->getBody());
        $barang = $response_body->data;

        return view('barang.view', compact('barang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/barang/show/' . $id, []);
        $response_body = json_decode($response->getBody());
        $barang = $response_body->data;

        $response = Http::withToken(session('jwt_token'))->get(env('API_URL') . 'api/jenis-barang', []);
        $response_body = json_decode($response->getBody());
        $jenis_barangs = $response_body->data->data;

        return view('barang.edit', compact('barang', 'jenis_barangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = Http::withToken(session('jwt_token'))->put(env('API_URL') . 'api/barang/update/' . $id, $request->all());

        if ($response->ok()) {

            return redirect()->route('barang.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response =  Http::withToken(session('jwt_token'))->delete(env('API_URL') . 'api/barang/delete/' . $id, []);

        if ($response->ok()) {

            return redirect()->route('barang.index')->with('success', "Data Berhasil Dihapus");
        }

        return redirect()->route('barang.index')->with('failed', 'Gagal Update Data');
    }
}
