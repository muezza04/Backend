@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$produk->nama_produk}}</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <a href="{{ url('home') }}" class="btn btn-primary"><i class="fa fa-arrow-left">Kembali</i></a>
        </div>
        <div class="col-md-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <!-- header untuk nama pesanannya -->
                    <h3>{{$produk->nama_produk}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ url('uploads') }}/{{ $produk->gambar}}" width="500" alt="">
                        </div>
                        <div class="col-md-6 mt-5">
                            <!-- membuat table untuk keterangan dari produknya -->
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Harga</td>
                                        <td> : </td>
                                        <td> Rp. {{number_format($produk->harga)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Stok</td>
                                        <td> : </td>
                                        <td> {{number_format($produk->stok)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td> : </td>
                                        <td> {{$produk->keterangan}}</td>
                                    </tr>
                                    <!-- method formnya post -->
                                    <tr>
                                        <td>Total Harga</td>
                                        <td>:</td>
                                        <td>
                                            <!-- menggunakan action url pesan -->
                                            <form action="{{ url('pesan') }}/{{ $produk->id }}" method="post">
                                                @csrf
                                                <input type="text" name="jumlah_pesanan" class="form-control " required>
                                                <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-shopping-cart"></i> Masukkan Ke Keranjang</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection