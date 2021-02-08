<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\DB;
use App\Berita;
use App\Jurusan;
class PostController extends Controller
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
    protected function views()
    {
    }
    protected function unUtama()
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $posts = Post::where('utama', '1')->get();
        if ($posts) {
            foreach ($posts as $post) {
                $post->utama = 0;
                $post->save();
                // dump($post);
            }
            $message = "BACKEND: berhasil unUtama data posting";
            $code = 200;
        } else {
            $message = "BACKEND: gagal meng-unUtama data posting";
        }
        // dump($posts);
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function store(Request $request)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;


        $this->unUtama(); //status utama dijadikan nol semua
        $post = new Post();
        $post->user_id = $request->user_id;
        $post->berita_id = $request->berita_id;
        $post->views = 0;
        $post->utama = 1;


        if ($post->save()) {
            $status = "success";
            $message = "BACKEND: Berita sudah di-post";
            $data = $post->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambahkan berita ke-post";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $code);
    }
    // Schema::create('posts', function (Blueprint $table) {
    //     $table->id();
    //     $table->integer('user_id')->nullable();
    //     $table->integer('berita_id')->nullable();
    //     $table->integer('views')->nullable();
    //     $table->integer('utama')->nullable();
    //     $table->timestamps();
    // });
    public function Utama($id)
    {
        // if (Auth::user()) {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $this->unUtama(); //status utama dijadikan nol semua
        $post = Post::find($id);
        $post->utama = 1;
        if ($post->save()) {
            $status = "success";
            $message = "BACKEND: Berita sudah di-post";
            $data = $post->toArray();
            $code = 200;
        } else {
            $message += "Gagal menambahkan berita ke-post";
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
    protected function addViews($id)
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        $post = Post::find($id);
        if ($post) {
            $post->views++;
            if ($post->save()) {
                $status = "success";
                $message = "BACKEND: post->views sudah ditambah";
                $data = $post->toArray();
                $code = 200;
            } else {
                $message = "BACKEND: post->views tidak bisa ditambah";
            }
        } else {
            $message = "BACKEND: post->views tidak ada post dengan id ini";
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

        $post = Post::where('id', '=', $id)->with(['berita.user'])->first();
        if ($post) {
            $this->addViews($post->id);
            $post = Post::where('id', '=', $id)->with(['berita.user'])->first();
            $status = "success";
            $message = "BACKEND: post->berita sudah diperoleh";
            $data = $post->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: post->berita tidak dapat diperoleh";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function showAll()
    {
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        // $post = Post::with(['berita'])
        //     ->andWith(['jurusan' => function ($q) use ($id) {
        //         $q->where('id', $id);
        //     }])->get();

        // $post = DB::table('posts')
        // ->leftJoin('beritas','beritas.id','=','posts.berita_id')
        // ->join('berita_jurusan','berita_id','=','beritas.id')
        // ->where('berita_jurusan.jurusan_id','=',$id)->get();

        // $post = Berita::with('post')
        //     ->with(['jurusan' => function ($q) use ($id) {
        //         $q->where('jurusan_id','=', $id);
        //     }])->get();

            // ->groupBy('posts.id')->get();
            
            // $post = Post::with(['berita' => function ($q) use ($id) {
            //     $q->with(['jurusan' =>function ($q) use ($id) {
            //         $q->where('jurusans.id','=',$id);
            //         // ->groupBy('jurusans.id');
            //     }]);
            // }])->get();
            $post = Post::with(['berita' => function ($q){
                $q->with(['jurusan']);
            }])->get();

            // $post = Post::where
            // $post = Berita::join('post')
            // ->join(['jurusan' => function ($q) use ($id) {
            //     $q->where('id','=',$id);
            // }])->get();
            // $post = DB::table('posts')
            // ->rightJoin('beritas','id','=','posts.berita_id')
            // ->join('berita_jurusan','berita_id','=','beritas.id')
            // ->where('berita_jurusan.jurusan_id','=',$id)
            // ->get();

        if ($post) {
            $status = "success";
            $message = "BACKEND: post->berita sudah diperoleh";
            $data = $post->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: post->berita tidak dapat diperoleh";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
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

        $post = Post::find($id);
        if ($post->delete()) {
            $status = "success";
            $message = "BACKEND: Data post telah dihapus";
            $data = $post->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Data post gagal dihapus";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function postperkategori($kategori_id)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;
        // $post = Post::with('berita')->get();
        $post = Berita::where('kategori_id', '=', $kategori_id)
            ->with(['post'])
            ->get();
        // $post = Post::with(['berita' => function ($q) use ($kategori_id) {
        //     $q->where('kategori_id', $kategori_id);
        // }])->get();
        // ->where('beritas.kategori_id', $kategori_id)->get();
        if ($post) {
            $status = "sukses";
            $message = "BACKEND: Sukses mengambil data post per kategori";
            $data = $post->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Gagal mengambil data post per kategori";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function postperkategori2($kategori_id)
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        $post = DB::table('beritas')
            ->join('posts', 'beritas.id', "=", "posts.berita_id")
            ->where('beritas.kategori_id', '=', $kategori_id)
            ->select('beritas.*', 'posts.created_at as post_created_at', 'posts.updated_at as post_udpated_at', 'posts.views')
            ->get();
        // ->where('beritas.kategori_id', $kategori_id)->get();
        if ($post) {
            $status = "sukses";
            $message = "BACKEND: Sukses mengambil data post per kategori";
            $data = $post->toArray();
            $code = 200;
        } else {
            $message = "BACKEND: Gagal mengambil data post per kategori";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function hits()
    {
        //
        $status = "error";
        $message = "BACKEND: ";
        $data = null;
        $code = 400;

        // $post = DB::table('beritas')
        //     ->join('posts', 'beritas.id', "=", "posts.berita_id")
        //     ->orderBy('posts.views','DESC')
        //     ->select('beritas.*','posts.created_at as post_created_at','posts.updated_at as post_udpated_at','posts.views')
        //     ->first();
        // ->where('beritas.kategori_id', $kategori_id)->get();
        $post = Post::orderBy('views', 'DESC')->with(['berita.user'])->first();
        if ($post) {
            $status = "sukses";
            $message = "BACKEND: Sukses mengambil data post paling hits";
            $data = $post;
            $code = 200;
        } else {
            $message = "BACKEND: Gagal mengambil data post paling hits";
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
