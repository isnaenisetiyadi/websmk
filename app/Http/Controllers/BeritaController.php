<?php

namespace App\Http\Controllers;

use App\Berita;
use App\Http\Resources\Berita as BeritaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    //
    public function index()
    {
        $berita = Berita::paginate(10);
        return new BeritaResource($berita);
    }
    public function showBySearch(Request $request)
    {

        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        if ($request->user_id) {

            $berita = Berita::where('user_id', '=', $request->user_id)
                ->where('judul', 'like', '%' . $request->judul . '%')->paginate(10);
        } else {
            $berita = Berita::where('judul', 'like', '%' . $request->judul . '%')->paginate(10);
        }


        if ($berita) {
            $status = "success";
            $message = "BACKEND: Data berita dengan pencarian diperoleh";
            $data = $berita->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data berita dengan pencarian TIDAK diperoleh";
        }
        return new BeritaResource($berita);
    }
    public function store(Request $request)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        DB::beginTransaction();
        $berita = new Berita();
        $berita->user_id = $request->user_id;
        $berita->kategori_id = $request->kategori_id;
        $berita->judul = $request->judul;
        $berita->deskripsi = $request->deskripsi;
        $berita->konten = $request->konten;
        if ($file = $request->file('avatar')) {
            $nameFile = $request->judul . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $berita->avatar = $nameFile;
            $file->move('images/berita/', $nameFile);
        }
        // dd($berita);
        if ($berita->save()) {
            $status = "success";
            $message = "BACKEND: Berita sudah ditambahkan";
            $data = $berita->toArray();
            $code = 200;

            if ($request->jurusans) {
                $itemJ = json_decode($request->jurusans);
                foreach ($itemJ as $jurusan) {
                    $berita->jurusan()->attach($jurusan, ['user_id' => $request->user_id]);
                }
            }

            if ($request->organisasis) {
                $itemO = json_decode($request->organisasis);
                foreach ($itemO as $organisasi) {
                    $berita->organisasi()->attach($organisasi, ['user_id' => $request->user_id]);
                    // dd($berita);
                }
            }
        } else {
            $message += "Gagal menambahkan berita";
        }
        DB::commit();
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function update(Request $request, $id)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        DB::beginTransaction();

        $berita = Berita::find($id);
        $berita->user_id = $request->user_id;
        $berita->kategori_id = $request->kategori_id;
        $berita->judul = $request->judul;
        $berita->deskripsi = $request->deskripsi;
        $berita->konten = $request->konten;
        if ($file = $request->file('avatar')) {
            $nameFile = $request->judul . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $berita->avatar = $nameFile;
            $file->move('images/berita/', $nameFile);
        }
        if ($berita->save()) {
            $status = "success";
            $message = "BACKEND: Berita sudah diupdate";
            $data = $berita->toArray();
            $code = 200;

            if ($request->jurusans) {
                $itemJ = json_decode($request->jurusans);
                foreach ($itemJ as $jurusan) {
                    if (!$berita->jurusan()->where('jurusan_id', $jurusan)->exists()) {
                        $berita->jurusan()->attach($jurusan, ['user_id' => $request->user_id]);
                    }
                }
            }

            if ($request->organisasis) {
                $itemO = json_decode($request->organisasis);
                foreach ($itemO as $organisasi) {
                    if (!$berita->organisasi()->where('organisasi_id', $organisasi)->exists()) {
                        $berita->organisasi()->attach($organisasi, ['user_id' => $request->user_id]);
                    }
                    // dd($berita);
                }
            }
        } else {
            $message += "Gagal mengupdate berita";
        }
        DB::commit();
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

        $berita = Berita::find($id);
        if ($berita->delete()) {
            $status = "success";
            $message = "BACKEND: Berita sudah dihapus";
            $data = $berita->toArray();
            $code = 200;
        } else {
            $message += "Gagal menghapus berita";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function excludeJurusan(Request $request)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $berita = Berita::find($request->berita_id);
        // $hasJurusan = ;
        // $user = User::find(1);
        // $hasTask = $user->tasks()->where('id', $taskId)->exists();
        if ($berita) {
            if ($berita->jurusan()->where('jurusan_id', $request->jurusan_id)->exists()) {
                if ($berita->jurusan()->detach($request->jurusan_id)) {
                    $status = "success";
                    $message = "BACKEND: Dihapus dari daftar berita jurusan";
                    $data = $berita->toArray();
                    $code = 200;
                } else {
                    $message = "BACKEND: gagal menghapus dari daftar berita jurusan";
                }
            } else {
                $message = "BACKEND: tidak menghapus dari database";
                // $data = $berita->toArray();
                $code = 200;
                $status = "success";
            }
        } else {
            $message = "BACKEND: tidak ada berita yg harus dihapus dari daftar berita jurusan";
            // $data = $berita->toArray();
            $code = 200;
            $status = "success";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function excludeOrganisasi(Request $request)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $berita = Berita::find($request->berita_id);
        // $hasJurusan = ;
        // $user = User::find(1);
        // $hasTask = $user->tasks()->where('id', $taskId)->exists();
        if ($berita) {
            if ($berita->organisasi()->where('organisasi_id', $request->organisasi_id)->exists()) {

                if ($berita->organisasi()->detach($request->organisasi_id)) {
                    $status = "success";
                    $message = "BACKEND: Dihapus dari daftar berita organisasi";
                    $data = $berita->toArray();
                    $code = 200;
                } else {
                    $message = "BACKEND: gagal menghapus dari daftar berita organisasi";
                }
            } else {

                $message = "BACKEND: tidak menghapus dari database";
                // $data = $berita->toArray();
                $code = 200;
                $status = "success";
            }
        } else {
            $message = "BACKEND: tidak ada berita yg harus dihapus dari daftar berita organisasi";
            // $data = $berita->toArray();
            $code = 200;
            $status = "success";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function show($id)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $berita = Berita::where('id', $id)
            ->with(['jurusan', 'organisasi'])->first();

        if ($berita) {
            $status = "success";
            $message = "BACKEND: Berhasil mengambil data berita";
            $data = $berita->toArray();
            $code = 200;
        } else {
            $message += "Gagal menghapus berita";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
