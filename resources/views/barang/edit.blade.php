@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Barang</h1>

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" value="{{ $barang->kode_barang }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" value="{{ $barang->stok }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" value="{{ $barang->harga }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" value="{{ $barang->lokasi }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Foto Sekarang</label><br>
            @if($barang->foto)
                <img src="{{ asset('storage/'.$barang->foto) }}" width="70">
            @endif
        </div>

        <div class="mb-3">
            <label>Ganti Foto (opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
