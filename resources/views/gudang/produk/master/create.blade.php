<x-app-layout menuActive="master" menuOpen="produk">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">TAMBAH MASTER PRODUK</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('gudang.produk.master') }}">Data Master Produk</a></li>
                <li class="breadcrumb-item active">Tambah Master Produk</li>
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

                    <form method="POST" action="{{ route('gudang.produk.master') }}">
                        @csrf
                        @include('gudang.produk.master.form')
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script src="/plugins/jquery/jquery.min.js"></script>

        <script src="   /plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src="   /plugins/select2/js/select2.full.min.js"></script>
        <script>
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4'
                })
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            });
        </script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    @endsection

</x-app-layout>
