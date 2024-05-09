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
                            <div class="col-md-12 col-lg-3">
                                <button type="button" onclick="confirmSave()" class="btn btn-success">
                                    Simpan Semua Perubahan
                                </button>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <form action="{{ route('sublayanan', ['id_layanan' => $subs->id]) }}" method="POST"
                                    id="myForm">
                                    @method('put')
                                    @csrf
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
                                                    <td>{{ $sub->jenis->jenis }} - {{ $sub->jenis->tipe }}
                                                        {{ $sub->jenis->tahun }}</td>
                                                    <td>
                                                        <input type="number" name="harga_jasa[{{ $sub->id }}]"
                                                            id="harga_jasa[{{ $sub->id }}]"
                                                            value="{{ $sub->harga_jasa }}"
                                                            class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="harga_jasa_khusus[{{ $sub->id }}]"
                                                            id="harga_jasa_khusus[{{ $sub->id }}]"
                                                            value="{{ $sub->harga_jasa_khusus }}"
                                                            class="form-control">

                                                    </td>
                                                    <td>Rp.
                                                        {{ number_format($sub->harga_jasa_khusus + $sub->harga_jasa) }}
                                                    </td>
                                                    <td>

                                                        <button class="btn btn-xs btn-primary" onclick="">
                                                            Simpan
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('css')
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    @endsection

    @section('js')
        <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="/plugins/jszip/jszip.min.js"></script>
        <script src="/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": [],
                    "bPaginate": false
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            });

            function confirmSave() {
                Swal.fire({
                    title: "Simpan Semua Perubahan ?",
                    text: "Pastikan data yang dimasukan sudah benar",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#myForm").submit();
                    }
                });
            }
        </script>
    @endsection

</x-app-layout>
