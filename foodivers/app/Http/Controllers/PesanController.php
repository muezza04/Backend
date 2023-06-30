<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Support\Facades\App;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;



class PesanController extends Controller
{
    // menambakan __contruct(), jika ada yang masuk ke halaman ini harus login dahulu.
    public function __construct()
    {
        $this->middleware('auth');
    }

    // membuat function index(), dengan parameter id
    public function index($id)
    {
        // first() untuk hanya mengambil satu data saja
        $produk = Produk::where('id', $id)->first();

        // return ke view
        return view('pesan.index', compact('produk'));
    }

    // membuat function pesan
    public function pesan(Request $request, $id)
    {
        // membuat variabel produk
        $produk = Produk::where('id', $id)->first();
        // membuat variabel tanggal
        $tanggal = Carbon::now();

        // membuat kondisi validasi batasan stok, agar tidak melebihi stok produk
        if ($request->jumlah_pesanan > $produk->stok) {
            return redirect('pesan/' . $id);
        }

        // membuat check validasi dengan membuat variabel cek_pesanan
        $cek_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // menyimpan ke database pesanan dengan
        if (empty($cek_pesanan)) {
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->total_harga = 0;
            $pesanan->kode = mt_rand(1000, 9999);
            $pesanan->save();
        }

        // menyimpan ke database detail pesanan
        // membuat variabel pesanan_baru untuk mengambil id pesanan
        $pesanan_baru = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // membuat variabel cek_detail_pesanan
        $cek_detail_pesanan = DetailPesanan::where('produk_id', $produk->id)->where('pesanan_id', $pesanan_baru->id)->first();

        // membuat kondisi cek_detail_pesanan
        if (empty($cek_detail_pesanan)) {
            $detail_pesanan = new DetailPesanan;
            $detail_pesanan->produk_id = $produk->id;
            $detail_pesanan->pesanan_id = $pesanan_baru->id;
            $detail_pesanan->jumlah = $request->jumlah_pesanan;
            $detail_pesanan->total_harga = $produk->harga * $request->jumlah_pesanan;
            $detail_pesanan->save();
        } else {
            $detail_pesanan = DetailPesanan::where('produk_id', $produk->id)->where('pesanan_id', $pesanan_baru->id)->first();
            $detail_pesanan->jumlah = $detail_pesanan->jumlah + $request->jumlah_pesanan;

            // membuat variabel harga_detail_pesanan_baru
            $harga_detail_pesanan_baru = $produk->harga * $request->jumlah_pesanan;
            $detail_pesanan->total_harga = $detail_pesanan->total_harga + $harga_detail_pesanan_baru;
            $detail_pesanan->update();
        }

        // membuat variabel untuk menjumlahkan total harganya
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $pesanan->total_harga = $pesanan->total_harga + $produk->harga * $request->jumlah_pesanan;
        $pesanan->update();

        Alert::success('Selamat', 'Anda telah memasukkan ke cart, silahkan cek cart anda');
        return redirect('home');
    }

    // membuat function baru bernama checkout
    public function checkout()
    {
        // meload pesanannya
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // memberikan kondisi untuk detail checkoutnya
        if (!empty($pesanan)) {
            $detail_pesanans = DetailPesanan::where('pesanan_id', $pesanan->id)->get();

            return view('pesan.checkout', compact('pesanan', 'detail_pesanans'));
        }
    }

    // membuat function baru bernama delete untuk dapat menghapus produk yang tidak jadi di beli di checkout
    public function delete($id)
    {
        // membuat variabel detail_pesanan terlebih dahulu agar dapat mengambil datanya dari database
        $detail_pesanan = DetailPesanan::where('id', $id)->first();

        // membuat variabel pesanan
        $pesanan = Pesanan::where('id', $detail_pesanan->pesanan_id)->first();
        $pesanan->total_harga = $pesanan->total_harga - $detail_pesanan->total_harga;
        $pesanan->update();

        $detail_pesanan->delete();
        return redirect('checkout');
    }

    // memnuat function bernama proceed-checkout, agar nantinya ketika kita dapat melakukan checkout
    public function proceedcheckout()
    {
        // membuat validasi user
        $user = User::where('id', Auth::user()->id)->first();

        // membuat kondisi untuk validasi user
        if (empty($user->alamat)) {
            Alert::error('Error Title', 'Error Message');
            return redirect('profile');
        }

        if (empty($user->no_hp)) {
            Alert::error('Error Title', 'Error Message');
            return redirect('profile');
        }

        // proceed checkout nantinya akan mengubah status dari 0 menjadi 1 yang artinya sudah berhasil dicheckout dan merubah stok barangnya
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $pesanan_id = $pesanan->id;
        $pesanan->status = 1;
        $pesanan->update();

        $detail_pesanans = DetailPesanan::where('pesanan_id', $pesanan_id)->get();
        foreach ($detail_pesanans as $detail_pesanan) {
            $produk = Produk::where('id', $detail_pesanan->produk_id)->first();
            $produk->stok = $produk->stok - $detail_pesanan->jumlah;
            $produk->update();
        }

        // alert untuk memberikan notifikasi sukses
        Alert::success('Selamat', 'Anda telah berhasil checkout, silahkan lakukan proses pembayaran ');
        return redirect('history/'. $pesanan_id);
    }
}
