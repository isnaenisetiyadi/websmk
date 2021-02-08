<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;
use App\Http\Resources\Kategori as KategoriResource;

class KategoriController extends Controller
{
    //
    public function index()
    {
        $kategoris = Kategori::all();
        return new KategoriResource($kategoris);
    }
    public function posts()
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $kategori = Kategori::with('berita.post')
            ->get();
        if ($kategori) {
            $status = "sukses";
            $message = "BACKEND: Sukses mengambil data berita dan post per kategori";
            $data = $kategori->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Gagal mengambil data berita dan post per kategori";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function showBerita(){
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $kategori = Kategori::with(['berita' => function ($q) {
            $q->with('post');
        }])->get();
        
        if ($kategori) {
            $status = "success";
            $message = "BACKEND: data kategori->berita sudah diperoleh";
            $data = $kategori->toArray();
            // $data = $kategori;
            $code = 200;
        } else {
            $message = "BACKEND: data kategori->berita tidak dapat diperoleh";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    // public function postbykategori()
    // {
    //     $status = "error";
    //     $message = "BACKEND: ";
    //     $data = null;
    //     $code = 400;

    //     $kategori = Kategori::with(['berita', 'post' => function ($q) {
    //         $q->where('berita_id', '=', 'beritas.id');
    //     }])
    //         ->get();
    //     if ($kategori) {
    //         $status = "success";
    //         $message = "BACKEND: Berhasil mengambil data kategori";
    //         $data = $kategori->toArray();
    //         $code = 200;
    //     } else {
    //         $message = "BACKEND: Gagal mengambil data kategori";
    //     }
    //     return response()->json([
    //         'status' => $status,
    //         'message' => $message,
    //         'data' => $data
    //     ], $code);
    // }
}
