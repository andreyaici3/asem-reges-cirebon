<x-app-layout menuActive="nonservice" menuOpen="">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">TRANSAKSI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Mohon Isi Data Dengan Benar</h3>
                    </div>

                    <div id="myForm">
                        @csrf
                        @include('kasir.formkasir')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
