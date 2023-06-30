@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <a href="{{ url('home') }}" class="btn btn-primary"><i class="fa fa-arrow-left">Kembali</i></a>
        </div>
        <div class="col-md-12 mt-3">
      
            <div class="card">
                <div class="card-body">
                    <h2 style="text-align: center;">Checkout</h2>
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
                                <th>Action</th>
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
                                <td>
                                    <form action="{{ url('checkout')}}/{{$detail_pesanan->id }}" method="post">
                                        @csrf
                                        <!-- diberikan method_field 'delete' untuk dapat menggunakan action delete atau menghapus produk yang tidak jadi di pesan -->
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm ('Anda Yakin ingin menghapus data?');"><i  class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <!-- menambahkan kolom tabel total harga dari keseluruhan barang yang ingin di checkout -->
                            <tr>
                                <td colspan="4" align="right"><strong> Total Harga :</strong></td>
                                <td><strong>Rp {{ number_format($pesanan->total_harga) }}</strong> </td>
                                <!-- membuat button untuk proceed checkout -->
                                <td>
                                    <a href="{{ url('proceed-checkout')}}" class="btn btn-success">Checkout</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection
