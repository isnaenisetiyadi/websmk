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

    public function showBerita()
    {
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
    public function store(Request $request)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $kategori = new Kategori();
        $kategori->nama = $request->nama;
        if ($kategori->save()) {
            $status = "success";
            $message = "BACKEND: Kategori sudah ditambahkan";
            $data = $kategori->toArray();
            $code = 200;
        } else {

            $message = "BACKEND: Kategori gagal ditambahkan";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function update(Request $request)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $kategori = Kategori::find($request->id);
        if ($kategori) {
            $kategori->nama = $request->nama;

            if ($kategori->save()) {
                $status = "success";
                $message = "BACKEND: Kategori sudah diupdate";
                $data = $kategori->toArray();
                $code = 200;
            } else {

                $message = "BACKEND: Kategori gagal diupdate";
            }
        } else {
            $message = "BACKEND: Tidak ada kategori dengan id ini";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function destroy($id)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $kategori = Kategori::find($id);
        if ($kategori) {
            if ($kategori->delete()) {
                $status = "success";
                $message = "BACKEND: Kategori sudah dihapus";
                $data = $kategori->toArray();
                $code = 200;
            } else {

                $message = "BACKEND: Kategori gagal dihapus";
            }
        } else {
            $message = "BACKEND: Tidak ada kategori dengan id ini";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
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
