@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Barang</h1>

    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control">
        </div>

        <div class="mb-3">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" id="kode_barang" class="form-control">
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="startScanner()">
            Scan Barcode
        </button>

        <div id="scanner-container" style="width: 400px; display:none;">
            <video id="scanner" width="400"></video>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control">
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi (opsional)</label>
            <input type="text" name="lokasi" class="form-control">
        </div>

        <div class="mb-3">
            <label>Foto (opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>

{{-- QuaggaJS Barcode Scanner --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<script>
function startScanner() {

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        alert("Browser tidak mendukung kamera.");
        return;
    }

    document.getElementById('scanner-container').style.display = 'block';
    let scanned = false;

    Quagga.init({
        inputStream : {
            name : "Live",
            type : "LiveStream",
            target: document.querySelector('#scanner'),
            constraints: {
                facingMode: "environment"
            }
        },
        decoder : {
            readers : ["code_128_reader", "ean_reader", "ean_8_reader"]
        }
    }, function(err) {
        if (err) {
            console.error(err);
            alert("Gagal mengakses kamera.");
            return;
        }
        Quagga.start();
    });

    Quagga.onDetected(function(result) {
        if (!scanned) {
            scanned = true;
            document.getElementById('kode_barang').value = result.codeResult.code;
            Quagga.stop();
            document.getElementById('scanner-container').style.display = 'none';
        }
    });
}
</script>

@endsection
