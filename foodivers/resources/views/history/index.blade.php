@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Riwayat Pemesanan</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-12">
            <a href="{{ url('home') }}" class="btn btn-primary"><i class="fa fa-arrow-left">Kembali</i></a>
        </div>
        <div class="col-md-12 mt-3">
            <!--Membuat table riwayat pemesanan  -->
            <div class="card">
                <div class="card-body">
                    <h2 style="text-align: center;">Riwayat Pemesanan</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($pesanans as $pesanan)
                            <tr>
                                <td>{{ $no++}}</td>
                                <td>{{ $pesanan->tanggal}}</td>
                                <td>
                                    @if($pesanan->status==1)
                                    Belum melakukan pembayaran
                                    @else
                                    Sudah dibayar
                                    @endif
                                </td>
                                <td>Rp {{ number_format($pesanan->total_harga) }}</td>
                                <td>
                                    <a href="{{ url('history') }}/{{ $pesanan->id}}" class="btn btn-primary">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection