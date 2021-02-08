<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Http\Resources\User as UserResource;
use SebastianBergmann\Environment\Console;

class AppController extends Controller
{
    //
    public function users()
    {
        $user = User::paginate(10);
        return new UserResource($user);
    }

    public function init()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json(Auth::user(), 200);
        } else {
            return response()->json(['error' => 'Gagal login'], 401);
        }
    }
    public function register(Request $request)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        // $user->avatar = "ujicoba";
        // proses pengambilan file avatar
        $nameFile = "";
        // dump($request->file('avatar')s);
        if ($file = $request->file('avatar')) {


            $nameFile = $request->name . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $user->avatar = $nameFile;
            $file->move('images/users/', $nameFile);
        }
        // if ($file = $request->file('avatar')) {
        //     // dd($file);
        // } else {
        //     $message = "| File avatar eror";
        //     // dd($message);
        // }
        if ($user->save()) {
            $status = "success";
            $message = "BACKEND: User sudah ditambahkan";
            $data = $user->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambahkan user";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
        // return response()->json($user, 200);
        // }
    }
    public function update(Request $request, $id)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role;

        $nameFile = "";
        if ($file = $request->file('avatar')) {
            $nameFile = $request->name . \Carbon\Carbon::now()->format('Y-m-dH:i:s') . '.' . $file->getClientOriginalExtension();
            $user->avatar = $nameFile;
            $file->move('images/users/', $nameFile);
        }
        if ($user->save()) {
            $status = "success";
            $message = "BACKEND: User sudah diupdate";
            $data = $user->toArray();
            $code = 200;
        } else {
            $message += "Gagal meng-update user";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
        // return response()->json($user, 200);
        // }
    }
    public function destroy($id)
    {
        // if (Auth::user()) {

        // Inisial pesan yang akan di return bersama data
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $user = User::find($id);
        if ($user->delete()) {
            $status = "success";
            $message = "BACKEND: Data user telah dihapus";
            $data = $user->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data user gagal dihapus";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
        // return response()->json($user, 200);
        // }
    }
    public function show($id)
    {
        // if (Auth::user()) {

        // Inisial pesan yang akan di return bersama data
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $user = User::find($id);
        if ($user) {
            $status = "success";
            $message = "BACKEND: Data user telah diperoleh";
            $data = $user->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data user gagal diperoleh";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
        // return response()->json($user, 200);
        // }
    }
    public function logout()
    {
        Auth::logout();
    }
}
