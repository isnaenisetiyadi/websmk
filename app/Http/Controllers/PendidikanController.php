<?php

namespace App\Http\Controllers;

use App\Pendidikan;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Pendidikan $pendidikan)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        // $pendidikan = new Pendidikan();
        // $pendidikan->user_id = $pendidikan->user_id;
        // $pendidikan->guru_id = $pendidikan->guru_id;
        // $pendidikan->jenjang = $pendidikan->jenjang;
        // $pendidikan->sekolah = $pendidikan->sekolah;
        // $pendidikan->tahun_masuk = $pendidikan->tahun_masuk;
        // $pendidikan->tahun_lulus = $pendidikan->tahun_lulus;

        if ($pendidikan->save()) {
            $status = "success";
            $message = "BACKEND: Data pendidikan sudah ditambahkan";
            $data = $pendidikan->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambah data pendidikan";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function simpan(Request $request)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $pendidikan = new Pendidikan();
        $pendidikan->user_id = $request->user_id;
        $pendidikan->guru_id = $request->guru_id;
        $pendidikan->jenjang = $request->jenjang;
        $pendidikan->sekolah = $request->sekolah;
        $pendidikan->tahun_masuk = $request->tahun_masuk;
        $pendidikan->tahun_lulus = $request->tahun_lulus;

        if ($pendidikan->save()) {
            $status = "success";
            $message = "BACKEND: Data pendidikan sudah ditambahkan";
            $data = $pendidikan->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambah data pendidikan";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $pendidikan = Pendidikan::find($request->id);
        $pendidikan->user_id = $request->user_id;
        $pendidikan->guru_id = $request->guru_id;
        $pendidikan->jenjang = $request->jenjang;
        $pendidikan->sekolah = $request->sekolah;
        $pendidikan->tahun_masuk = $request->tahun_masuk;
        $pendidikan->tahun_lulus = $request->tahun_lulus;

        if ($pendidikan->save()) {
            $status = "success";
            $message = "BACKEND: Data pendidikan sudah diupdate";
            $data = $pendidikan->toArray();
            $code = 200;
        } else {
            $message += "Gagal meng-update data pendidikan";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $pendidikan = Pendidikan::find($id);
        if ($pendidikan->delete()) {
            $status = "success";
            $message = "BACKEND: Data pendidikan telah dihapus";
            $data = $pendidikan->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data pendidikan gagal dihapus";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
