<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sekolah;
use Illuminate\Support\Str;
class SekolahController extends Controller
{
    //

    public function showAll()
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $sekolah = Sekolah::with('misi')
            ->with('guru')->first();
        if ($sekolah) {
            $status = "success";
            $message = "BACKEND: sukses mengambil data sekolah";
            $data = $sekolah->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: gagal mengambil data sekolah";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function update(Request $request, $id)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $sekolah = Sekolah::find($id);
        if ($sekolah) {
            $sekolah->user_id = $request->user_id;
            $sekolah->guru_id = $request->guru_id;
            $sekolah->alamat = $request->alamat;
            $sekolah->email = $request->email;
            $sekolah->visi = $request->visi;
            $sekolah->moto1 = $request->moto1;
            $sekolah->moto2 = $request->moto2;

            if ($file = $request->file('logo')) {
                $nameFile = 'logo' . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
                $sekolah->logo = $nameFile;
                $file->move('images/sekolah/', $nameFile);
            }
            if ($file = $request->file('avatar')) {
                $nameFile = 'avatar' . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
                $sekolah->avatar = $nameFile;
                $file->move('images/sekolah/', $nameFile);
            }

            if ($sekolah->save()) {

                $status = "success";
                $message = "BACKEND: Data sekolah berhasil di-update";
                $data = $sekolah->toArray();
                $code = 200;
            } else {

                $message = "BACKEND: gagal meng-update data sekolah";
            }
        } else {
            $message = "BACKEND: gagal meng-update data sekolah";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
