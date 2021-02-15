<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Misi;

class MisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $status = "error";
        // $message = "BACKEND: ";
        // $data = null;
        // $code = 400;
        // $misi = Misi::where('')
    }

    // public function showbyid()

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

        $misi = new Misi();
        $misi->user_id = $request->user_id;
        $misi->sekolah_id = $request->sekolah_id;
        $misi->text = $request->text;
        if ($file = $request->file('avatar')) {
            $nameFile = 'misi' . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $misi->avatar = $nameFile;
            $file->move('images/sekolah/', $nameFile);
        }

        if ($misi->save()) {
            $status = "success";
            $message = "BACKEND: sukses menambah misi sekolah";
            $data = $misi->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: GAGAL menambah misi sekolah";
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

        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $misi = Misi::find($id);
        $misi->user_id = $request->user_id;
        $misi->sekolah_id = $request->sekolah_id;
        $misi->text = $request->text;
        if ($file = $request->file('avatar')) {
            $nameFile = 'misi' . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $misi->avatar = $nameFile;
            $file->move('images/sekolah/', $nameFile);
        }

        if ($misi->save()) {
            $status = "success";
            $message = "BACKEND: sukses meng-update misi sekolah";
            $data = $misi->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: GAGAL meng-update misi sekolah";
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

        $misi = Misi::find($id);
       
        if ($misi) {

            if ($misi->delete()) {
                $status = "success";
                $message = "BACKEND: sukses menghapus misi sekolah";
                $data = $misi->toArray();
                $code = 200;
            } else {
                $message = "BACKEND: GAGAL menghapus misi sekolah";
            }
        }else {
            $message = "Tidak ada misi dengan id itu yang akan dihapus";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
