<x-app-layout menuActive="pelanggan" menuOpen="">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">TRANSAKSI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mekanik.pelanggan') }}">Data Customer</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('mekanik.transaksi.bypelanggan', ['id_pelanggan' => $customer->id]) }}">{{ $customer->name }}</a>
                </li>
                <li class="breadcrumb-item active">Tambah Transaksi</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                @if (Session::has('sukses'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Selamat!</h5>
                        {{ session('sukses') }}
                    </div>
                @endif

                @if (Session::has('gagal'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Oopss!</h5>
                        {{ session('gagal') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h5>Nama Customer: <b>{{ $customer->name }}</b></h5>
                    <p>
                        Mobil: <b>{{ $customer->tipe_mobil->merk->name }} - {{ $customer->tipe_mobil->name }}</b> <br>
                        Plat Nomor: <b>{{ $customer->number_plat }}</b> <br>
                        Tanggal Transaksi: <b>{{ date('d-m-Y') }}</b><br>
                        Mekanik: <b>{{ Auth::user()->name }}</b>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Mohon Isi Data Dengan Benar</h3>
                    </div>

                    <div id="myForm">
                        @csrf
                        @include('mekanik.transaksi.formcreate')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
