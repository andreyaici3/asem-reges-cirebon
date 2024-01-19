<x-app-layout menuActive="branch">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">TAMBAH CABANG</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('super.cabang') }}">Data Cabang</a></li>
                <li class="breadcrumb-item active">Tambah Cabang</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Silahkan Isi Semua Data</h3>
                    </div>

                    <form method="POST" action="{{ route('super.cabang') }}">
                        @csrf
                         @include("super.cabang.form")
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
