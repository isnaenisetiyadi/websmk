<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
 
use App\Jurusan;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jurusan = Jurusan::paginate(5);
        return $jurusan;
    }

    public function getAll()
    {
        $jurusan = Jurusan::all();
        return $jurusan;
    }
    public function showAll()
    {

        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        // $jurusan = Jurusan::with('guru')->get();
        $jurusan = Jurusan::with('guru')
            ->with(['berita' => function ($q) {
                $q->with('post');
            }])->get();
        if ($jurusan) {
            $status = "success";
            $message = "BACKEND: data jurusan sudah diperoleh";
            $data = $jurusan->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: data jurusan tidak dapat diperoleh";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
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
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $jurusan = new Jurusan();
        $jurusan->user_id = $request->user_id;
        $jurusan->nama = $request->nama;
        $jurusan->deskripsi = $request->deskripsi;
        $jurusan->slug = Str::slug($request->nama);

        if ($file = $request->file('logo')) {
            $nameFile = $request->nama . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $jurusan->logo = $nameFile;
            $file->move('images/jurusan/', $nameFile);
        }
        if ($jurusan->save()) {
            $status = "success";
            $message = "BACKEND: Jurusan sudah ditambahkan";
            $data = $jurusan->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambahkan jurusan";
            // DB::rollback();
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
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $jurusan = Jurusan::where('id', '=', $id)->with(['guru'])
            ->get();
        if ($jurusan) {
            $status = "success";
            $message = "BACKEND: data jurusan diperoleh";
            $data = $jurusan->toArray();
            $code = 200;
        } else {
            $message += "Gagal mengambil data jurusan";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function slug($slug)
    {
        //
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $jurusan = Jurusan::where('slug', '=', $slug)->with(['guru'])
            ->get();
        if ($jurusan) {
            $status = "success";
            $message = "BACKEND: data jurusan diperoleh";
            $data = $jurusan->toArray();
            $code = 200;
        } else {
            $message += "Gagal mengambil data jurusan";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
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

        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $jurusan = Jurusan::find($id);
        $jurusan->user_id = $request->user_id;
        $jurusan->nama = $request->nama;
        $jurusan->deskripsi = $request->deskripsi;
        $jurusan->slug = Str::slug($request->nama);

        if ($file = $request->file('logo')) {
            $nameFile = $request->nama . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $jurusan->logo = $nameFile;
            $file->move('images/jurusan/', $nameFile);
        }
        if ($jurusan->save()) {
            $status = "success";
            $message = "BACKEND: Jurusan sudah diupdate";
            $data = $jurusan->toArray();
            $code = 200;
        } else {
            $message += "Gagal meng-update jurusan";
            // DB::rollback();
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
        $jurusan = Jurusan::find($id);
        if ($jurusan->delete()) {
            $status = "success";
            $message = "BACKEND: Data jurusan telah dihapus";
            $data = $jurusan->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data jurusan gagal dihapus";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
