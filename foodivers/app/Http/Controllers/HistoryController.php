<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\App;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    // membuat construktor
    public function __construct()
    {
        $this->middleware('auth');
    }

    // membuat function index
    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status', '!=', 0)->get();
        return view('history.index', compact('pesanans'));
    }

    // membuat function detail untuk riwayat pesanan
    public function detail($id)
    {
        // membuat variabel $pesanan
        $pesanan = Pesanan::where('id', $id)->first();
        // membuat variabel detail_pesanan agar bisa mengambil data nya dari database detail pesanan
        $detail_pesanans = DetailPesanan::where('pesanan_id', $pesanan->id)->get();

        return view('history.detail', compact('pesanan', 'detail_pesanans'));
    }
}
