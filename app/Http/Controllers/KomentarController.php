<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Komentar;
use App\Http\Resources\Komentar as KomentarResource;
// use App\Http\Controllers\Builder;
use Illuminate\Support\Facades\DB;

class KomentarController extends Controller
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
    public function store(Request $request)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $komentar = new Komentar();
        $komentar->user_id = $request->user_id;
        $komentar->berita_id = $request->berita_id;
        $komentar->komentar_id = $request->komentar_id;
        $komentar->komen = $request->komen;

        if ($komentar->save()) {
            $status = "success";
            $message = "BACKEND: Komentar sudah disimpan";
            $data = $komentar->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Gagal mengambah komentar";
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
    public function update(Request $request, $id)
    {
        //
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
    }
    public function showByBeritaId($berita_id)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $komentar = Komentar::where('berita_id', '=', $berita_id)
            ->orderBy('created_at', 'DESC')
            ->with(['user'])
            ->get();

        // $komentar = Komentar::withCount(['komentar' => function($q) use($berita_id) {
        //     $q->where('berita_id', '=', $berita_id);
        // }])->get();

        // $komentar = DB::table('komentars')
        // ->where('berita_id','=', $berita_id)
        // ->orderBy('created_at','DESC')
        // ->select('*')
        // ->get();

        if ($komentar) {
            $status = "success";
            $message = "BACKEND: Data komentar berdasarkan berita";
            $data = $komentar->toArray();
            $code = 200;
        } else {
            $message += "Data komentar berdasarkan id " + $berita_id + " Tidak ditemukan";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
