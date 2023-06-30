@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('history')}}">Riwayat Pesanan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pesanan</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <a href="{{ url('home') }}" class="btn btn-primary"><i class="fa fa-arrow-left">Kembali</i></a>
        </div>
        <div class="col-md-12 mt-3">
      
            <div class="card">
                <div class="card-body">
                    <h2 style="text-align: center;">Detail Pesanan</h2>
                    <!-- membuat kondisi -->
                    @if(!empty($pesanan))
                    <!-- membuat tanggal pesanan -->
                    <p>Tanggal Order : {{ $pesanan->tanggal }}</p>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total Harga</th>
                                <th>Kode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($detail_pesanans as $detail_pesanan)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{ $detail_pesanan->produk->nama_produk}}</td>
                                <td>{{ $detail_pesanan->jumlah}} pcs</td>
                                <td>Rp {{ number_format($detail_pesanan->produk->harga)}}</td>
                                <td>Rp {{ number_format($detail_pesanan->total_harga)}}</td>
                                <td>{{ $pesanan->kode }}</td>
                            </tr>
                            @endforeach
                            <!-- menambahkan kolom tabel total harga dari keseluruhan barang yang ingin di checkout -->
                            <tr>
                                <td colspan="4" align="right"><strong> Total Harga :</strong></td>
                                <td><strong>Rp {{ number_format($pesanan->total_harga) }}</strong> </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div> 
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h3 align="center">Sukses Checkout <i class="fa fa-check" style="color: green;" ></i></h3>
                </div>
                <div class="card-body">
                    <h4>Pesanan anda telah sukses dicheckot, untuk pembayaran silahkan di transfer ke rekening. <br> <strong> M-banking BNI : 1893423423677</strong> <br> Dengan nominal : <strong>Rp {{number_format($pesanan->total_harga) }}</strong></h4> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
