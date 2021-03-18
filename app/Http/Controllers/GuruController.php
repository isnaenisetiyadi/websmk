<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Pendidikan;
use App\Http\Resources\Guru as GuruResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\Throwable;
use Exception;
use PhpParser\Node\Expr\Cast\Object_;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $guru = Guru::with(['pendidikan'])->get();
        $guru = Guru::with(['pendidikan', 'jurusan'])
            ->paginate(5);
        // ->with(['pendidikan']);
        return new GuruResource($guru);
        // return $guru;
    }

    public function showByName($nama)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        if ($nama) {

            $guru = Guru::where('nama', 'like', '%' . $nama . '%')
                ->with(['pendidikan', 'jurusan']) //->get();
                ->paginate(5);
        } else {
            $guru = Guru::with(['pendidikan', 'jurusan']) //->get();
                ->paginate(5);
        }
        if ($guru) {
            $status = "error";
            $message = "BACKEND: Data guru diperoleh semuanya";
            // $data = $guru->toArray();
            $data = new GuruResource($guru);
            $code = 200;
        } else {
            $message = "BACKEND: Data guru dengan kata kunci tersebut tidak ada";
        }
        // return response()->json([
        //     'status' => $status,
        //     'message' => $message,
        //     'data' => new GuruResource($data)
        // ], $code);
        return new GuruResource($guru);
    }

    public function showAll()
    {
        $guru = Guru::all();

        return $guru;
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
    protected function getId($randomKey)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $guru = Guru::where('randomkey', '=', $randomKey)->first();
        if ($guru) {
            $status = "success";
            $message = "BACKEND: Data guru diperoleh";
            $data = $guru->id;
            // dd($guru->id);
            $code = 200;
        } else {
            $message += "Gagal memperolah data guru";
        }

        return $data;
        // return response()->json([
        //     'status' => $status,
        //     'message' => $message,
        //     'data' => $data
        // ], $code);
    }

    public function store(Request $request)
    {
        //

        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        DB::beginTransaction(); // membuka transaksi

        $randomKey = Str::random(64);

        $guru = new Guru();
        $guru->user_id = $request->user_id;
        $guru->nip = $request->nip;
        $guru->nuptk = $request->nuptk;
        $guru->nama = $request->nama;
        $guru->email = $request->email;
        $guru->alamat = $request->alamat;
        $guru->kontak = $request->kontak;
        $guru->jabatan = $request->jabatan;
        $guru->randomkey = $randomKey;
        $guru->slug = Str::slug($request->nama);
        $namaFile = "";

        if ($file = $request->file('avatar')) {
            $nameFile = $request->nama . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $guru->avatar = $nameFile;
            $file->move('images/guru/', $nameFile);
        }
        if ($guru->save()) {
            $status = "success";
            $message = "BACKEND: Guru sudah ditambahkan";
            $data = $guru->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambahkan guru";
            // DB::rollback();
        }

        // DB::commit();
        if ($request->pendidikans) {

            //megambil id
            $idguru = $this->getId($randomKey);
            // dd($idguru);
            // dd($request->pendidikans);
            $PendidikanController = new PendidikanController;
            $itemP = json_decode($request->pendidikans, true);
            // echo ($request->pendidikans->sekolah);

            // dd($itemP);

            foreach ($itemP as $pendidikan) {
                $itemPendidikan = new Pendidikan();
                $itemPendidikan->user_id = $pendidikan['user_id'];
                $itemPendidikan->guru_id = $idguru;
                $itemPendidikan->jenjang = $pendidikan['jenjang'];
                $itemPendidikan->sekolah = $pendidikan['sekolah'];
                $itemPendidikan->tahun_masuk = $pendidikan['tahun_masuk'];
                $itemPendidikan->tahun_lulus = $pendidikan['tahun_masuk'];
                // dd($itemPendidikan);

                $PendidikanController->store($itemPendidikan);
            }
        }

        DB::commit(); // menutup transaksi

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
        // try {
        //     // Validate the value...

        // } catch (Exception $e) {
        //     DB::rollback();
        // }
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

        $guru = Guru::where('id', '=', $id)->with(['pendidikan'])->get();
        if ($guru) {
            $status = "success";
            $message = "BACKEND: data guru diperoleh";
            $data = $guru->toArray();
            $code = 200;
        } else {
            $message += "Gagal mengambil data guru";
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

        $guru = Guru::where('slug', '=', $slug)->with(['pendidikan'])->get();
        if ($guru) {
            $status = "success";
            $message = "BACKEND: data guru diperoleh";
            $data = $guru->toArray();
            $code = 200;
        } else {
            $message += "Gagal mengambil data guru";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function getGuruJurusan(Request $request)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $list_id = json_decode($request->list_id, true);

        $guru = Guru::where('nama', 'like', $request->keyword . '%')
            ->WhereNotIn('id', $list_id)->get();

        if ($guru) {
            $status = "success";
            $message = "BACKEND: data guru diperoleh";
            $data = $guru->toArray();
            $code = 200;
        } else {
            $message += "Gagal mengambil data guru";
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

        $guru = Guru::find($id);
        $guru->nama = $request->nama;
        $guru->nip = $request->nip;
        $guru->nuptk = $request->nuptk;
        $guru->alamat = $request->alamat;
        $guru->email = $request->email;
        $guru->kontak = $request->kontak;
        $guru->jabatan = $request->jabatan;
        $guru->slug = Str::slug($request->nama);
        // $namaFile = "";
        if ($file = $request->file('avatar')) {
            $nameFile = $request->nama . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $guru->avatar = $nameFile;
            $file->move('images/guru/', $nameFile);
        }
        if ($guru->save()) {
            $status = "success";
            $message = "BACKEND: Guru sudah diupdate";
            $data = $guru->toArray();
            $code = 200;
        } else {
            $message += "Gagal meng-update guru";
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
        $guru = Guru::find($id);
        if ($guru->delete()) {
            $status = "success";
            $message = "BACKEND: Data guru telah dihapus";
            $data = $guru->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data guru gagal dihapus";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function excludeJurusan(Request $request)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $guru = Guru::find($request->guru_id);
        if ($guru->jurusan()->detach($request->jurusan_id)) {
            $status = "success";
            $message = "BACKEND: guru ini sudah dikeluarkan dari daftar guru kejuruan";
            $data = $guru->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: gagal mengeluarkan guru dari daftar guru kejuruan";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function includeJurusan(Request $request)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        if ($request->gurudipilih) {
            DB::beginTransaction();

            $jsonGuruDipilih = json_decode($request->gurudipilih);
            // dd($jsonGuruDipilih);
            foreach ($jsonGuruDipilih as $gurudipilih) {
                // dd($gurudipilih);
                $guru = Guru::find($gurudipilih);
                // dd($guru);
                if ($guru) {
                    $guru->jurusan()->attach($request->jurusan_id, ['user_id' => $request->user_id]);
                    $status = "success";
                    $message = "BACKEND: guru ini sudah masukkan ke daftar guru kejuruan";
                    // $data = $guru->toArray();
                    $code = 200;
                } else {
                    $message = "BACKEND: Gagal menambah daftar guru kejuruan";
                }
            }
            DB::commit();
        }

        // $user->roles()->attach($roleId, ['expires' => $expires]);

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
