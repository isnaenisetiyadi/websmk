<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    //
    public function showByOrganisasiSearch(Request $request)
    {

        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $program = new Program();
        if ($request->organisasi_id) {

            $program = Program::where('nama', 'like', $request->keyword . '%')
                ->where('organisasi_id', '=', $request->organisasi_id)->get();
        } else {
            $program = Program::where('nama', 'like', $request->keyword . '%')->get();
        }
        if ($program) {
            $status = "success";
            $message = "BACKEND: data program berdasarkan organisasi diperoleh";
            $data = $program->toArray();
            $code = 200;
        } else {
            $message = "Gagal memperoleh program berdasarkan organisasi";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function store(Request $request)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $program = new Program();
        $program->user_id = $request->user_id;
        $program->organisasi_id = $request->organisasi_id;
        $program->nama = $request->nama;
        $program->deskripsi = $request->deskripsi;
        $program->konten = $request->konten;
        $program->slug = Str::slug($request->nama);
        if ($file = $request->file('avatar')) {
            $nameFile = $request->nama . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $program->avatar = $nameFile;
            $file->move('images/program/', $nameFile);
        }

        if ($program->save()) {
            $status = "success";
            $message = "BACKEND: Program kerja sudah ditambahkan";
            $data = $program->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambahkan program kerja";
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

        $program = Program::find($id);
        $program->user_id = $request->user_id;
        $program->organisasi_id = $request->organisasi_id;
        $program->nama = $request->nama;
        $program->deskripsi = $request->deskripsi;
        $program->konten = $request->konten;
        $program->slug = Str::slug($request->nama);
        // dd($request->avatar);
        if ($file = $request->file('avatar')) {
            $nameFile = $request->nama . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $program->avatar = $nameFile;
            $file->move('images/program/', $nameFile);
        }

        if ($program->save()) {
            $status = "success";
            $message = "BACKEND: Program kerja sudah di-update";
            $data = $program->toArray();
            $code = 200;
        } else {
            $message += "Gagal meng-update program kerja";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function destroy($id)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $program = Program::find($id);
        if ($program->delete()) {
            $status = "success";
            $message = "BACKEND: Data program telah dihapus";
            $data = $program->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data program gagal dihapus";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function show($id)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $program = Program::where('id', '=', $id)->first();
        if ($program) {
            $status = "success";
            $message = "BACKEND: data program diperoleh";
            $data = $program->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: data tidak program diperoleh";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
