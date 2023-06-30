<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // membuat variabel produks dan mengambil database produk,  yang nantinya akan menampilkan produknya, maka diberikan method paginate() agar data yag muncul dapat dibatasi.  
        $produks = Produk::paginate(25);
        // variabel barang langsung di arahkan ke view
        return view('home', compact('produks'));
    }
}
