<x-app-layout menuActive="maping">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">TAMBAH KEPALA CABANG</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('super.kepala') }}">Data Maping Kepala Cabang</a></li>
                <li class="breadcrumb-item active">Tambah Kepala Cabang</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Pilih Kepala Cabang Beserta Cabangnya</h3>
                    </div>

                    <form method="POST" action="{{ route('super.kepala') }}">
                        @csrf
                        @include('super.kepala.form', [
                            "branch" => $branch,
                            "admin" => $admin
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('css')
        <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    @endsection

    @section('js')
        <script src="/plugins/select2/js/select2.full.min.js"></script>
        <script>
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        </script>
    @endsection
</x-app-layout>
