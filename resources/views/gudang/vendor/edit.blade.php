<x-app-layout menuActive="vendor">
    @section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">EDIT VENDOR</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('gudang.vendor') }}">Data Vendor</a></li>
            <li class="breadcrumb-item active">Edit Data Vendor</li>
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

                    <form method="POST" action="{{ route('gudang.vendor.update', ['id' => $vendor->id]) }}">
                        @csrf
                        @method('put')
                        @include("gudang.vendor.form")
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>