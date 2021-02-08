<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisasi;
use App\Http\Resources\Organisasi as OrganisasiResource;

class OrganisasiController extends Controller
{
    //
    public function index()
    {
        $organisasi = Organisasi::paginate(5);
        // return $organisasi;
        return new OrganisasiResource($organisasi);
    }
    public function getall()
    {
        $organisasi = Organisasi::all();
        return $organisasi;
    }
    public function showAll()
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $organisasi = Organisasi::with('program')
            ->with(['berita' => function ($q) {
                $q->with('post');
            }])->get();

        if ($organisasi) {
            $status = "success";
            $message = "BACKEND: data organisasi sudah diperoleh";
            $data = $organisasi->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: data organisasi tidak dapat diperoleh";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function store(Request $request)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $organisasi = new Organisasi();
        $organisasi->user_id = $request->user_id;
        $organisasi->nama = $request->nama;
        $organisasi->deskripsi = $request->deskripsi;

        if ($file = $request->file('avatar')) {
            $nameFile = $request->nama . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $organisasi->avatar = $nameFile;
            $file->move('images/organisasi/', $nameFile);
        }

        if ($organisasi->save()) {
            $status = "success";
            $message = "BACKEND: Organisasi sudah ditambahkan";
            $data = $organisasi->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambahkan organisasi";
            // DB::rollback();
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function show($id)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $organisasi = Organisasi::where('id', '=', $id)->with(['program'])
            ->get();
        if ($organisasi) {
            $status = "success";
            $message = "BACKEND: data organisasi diperoleh";
            $data = $organisasi->toArray();
            $code = 200;
        } else {
            $message += "Gagal mengambil data organisasi";
        }
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

        $organisasi = Organisasi::find($id);
        $organisasi->user_id = $request->user_id;
        $organisasi->nama = $request->nama;
        $organisasi->deskripsi = $request->deskripsi;

        if ($file = $request->file('avatar')) {
            $nameFile = $request->nama . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $organisasi->avatar = $nameFile;
            $file->move('images/organisasi/', $nameFile);
        }

        if ($organisasi->save()) {
            $status = "success";
            $message = "BACKEND: Organisasi sudah diupdate";
            $data = $organisasi->toArray();
            $code = 200;
        } else {
            $message += "Gagal meng-update data organisasi";
            // DB::rollback();
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function destroy($id)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $organisasi = Organisasi::find($id);
        if ($organisasi->delete()) {
            $status = "success";
            $message = "BACKEND: Data organisasi telah dihapus";
            $data = $organisasi->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data organisasi gagal dihapus";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
