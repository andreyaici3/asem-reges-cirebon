<x-app-layout menuActive="merk-mobil" menuOpen="car">
    @section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">EDIT TIPE MOBIL {{ strtoupper($merk->name) }}</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gudang.mobil.merk') }}">Data Merk Mobil</a></li>
            <li class="breadcrumb-item active">Edit Tipe Mobil</li>
        </ol>
    </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Mohon Isi Data Dengan Benar</h3>
                    </div>

                    <form method="POST" action="{{ route('gudang.mobil.type.update', ["id_type" => $type->id, "id_merk" => $merk->id]) }}">
                        @csrf
                        @method('put')
                        @include("gudang.mobil.type.form")
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>