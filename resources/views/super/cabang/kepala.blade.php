<x-app-layout menuActive="branch">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">KEPALA CABANG</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('super.cabang') }}">Data Cabang</a></li>
                <li class="breadcrumb-item active">Edit Kepala Cabang</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Pilih Kepala Cabang Untuk - {{ $chief->branch->name }}</h3>
                    </div>

                    <form method="POST" action="{{ route('super.cabang') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Pilih Kepala Cabang</label>
                                <select class="form-control select2bs4" style="width: 100%;">
                                    <option value="NULL">- Belum Ada Kepala -</option>
                                    @foreach ($admin as $value)
                                        <option>{{ $value->name }} - {{ $value->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
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
