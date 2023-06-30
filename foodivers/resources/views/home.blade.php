@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
                <!-- logo di body -->
                <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="{{ url('images/logo_foodivers.png') }}" width="300" alt="..." /></div>
                <div class="col-lg-5">
                    <h1 class="font-weight-light">Foodivers</h1>
                    <p>Foodivers adalah website toko makanan online, yang menyediakan aneka macam makanan dan harga makanan yang tersedia disini dibandrol dengan harga yang terjangkau.</p>
                    <a class="btn btn-primary" href="#!">Selengkapnya</a>
                </div>
            </div>
            <nav class="navbar navbar-light bg-light mb-3">
                <form class="container-fluid">
                    <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">Search</span>
                    <input type="text" class="form-control" placeholder="Cari Produk" aria-label="#" aria-describedby="basic-addon1">
                    </div>
                </form>
            </nav>
        <!-- untuk menampilkan data, dengan cara foreach -->
        @foreach($produks as $produk)
        <!-- membuat card untuk produk-produknya -->
        <div class="col-md-3">
            <div class="card mb-3">
                <img class="card-img-top" src="{{ url('uploads') }}/{{$produk->gambar }}"  alt="Card image cap">
                 <div class="card-body">
                    <!-- menambahkan nama produk yang diambil dari database -->
                    <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                    <p class="card-text">
                        <!-- menambahkan harga produk yang diambil dari database -->
                        <strong>Harga :</strong> Rp. {{ number_format($produk->harga)}} <br>
                        <strong>Stok Produk : </strong> {{ $produk->stok }} <br>
                        <hr>
                        <strong>Keterangan : </strong> {{ $produk->keterangan}} 
                    </p>
                    <!-- memberikan link agar bisa di arahkan ke halaman pesanan -->
                    <a href="{{ url('pesan') }}/{{ $produk->id }}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Pesan</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
