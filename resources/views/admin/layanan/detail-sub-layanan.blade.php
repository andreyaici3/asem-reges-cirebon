<x-app-layout menuActive="service">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">Detail Sub Layanan {{ $subs->service_name }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('layanan') }}">Data Layanan</a></li>
                <li class="breadcrumb-item active">Detail Sub Layanan</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12">
                                @if (Session::has('sukses'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-check"></i> Selamat!</h5>
                                        {{ session('sukses') }}
                                    </div>
                                @endif

                                @if (Session::has('gagal') || $errors->has('name'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-ban"></i> Oopss!</h5>
                                        {{ session('gagal') }} | {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-3">
                                <button type="button" onclick="resetform()" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Layanan
                                </button>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Mobil</th>
                                            <th>Harga Jasa</th>
                                            <th>Harga Jasa Khusus</th>
                                            <th>Total Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $nomor = 1;
                                        @endphp
                                        @foreach ($subs->sublayanan as $sub)
                                            <tr>
                                                <td>{{ $nomor++ }}</td>
                                                <td>{{ $sub->jenis->jenis }} - {{ $sub->jenis->tipe }} {{ $sub->jenis->tahun }}</td>
                                                <td>Rp. {{ number_format($sub->harga_jasa) }}</td>
                                                <td>Rp. {{ number_format($sub->harga_jasa_khusus) }}</td>
                                                <td>Rp. {{ number_format($sub->harga_jasa_khusus + $sub->harga_jasa) }}</td>
                                                <td>
                                                    
                                                    <button class="btn btn-xs btn-primary"
                                                        onclick="">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>|
                                                    <form id="delete"
                                                        action=""
                                                        style="display: inline-block;" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button"
                                                            onclick=""
                                                            class="btn btn-xs btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                            Hapus
                                                        </button>
                                                    </form>
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
        </div>
    </div>

</x-app-layout>
