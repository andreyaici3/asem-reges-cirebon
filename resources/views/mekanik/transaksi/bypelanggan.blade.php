<x-app-layout menuActive="pelanggan" menuOpen="">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">DATA TRANSAKSI BY PELANGGAN</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Transaksi</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $customer->name }}</h3>

                        <p>{{ $customer->number_plat }} - {{ $customer->tipe_mobil->merk->name }} -
                            {{ $customer->tipe_mobil->name }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>

                </div>
            </div>
        </div>
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

                                @if (Session::has('gagal'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>
                                        <h5><i class="icon fas fa-ban"></i> Oopss!</h5>
                                        {{ session('gagal') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Deskripsi</th>
                                            <th>Total Pembayaran</th>
                                            <th>Mekanik</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksis as $transaksi)
                                            <tr>
                                                <td>{{ $nomor++ }}</td>
                                                <td>{{ Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y') }}
                                                </td>
                                                <td>{{ $transaksi->description }}</td>
                                                <td>Rp. {{ number_format($transaksi->total_purchased) }}</td>
                                                <td>{{ $transaksi->mekanik->name }}</td>
                                                <td>{{ $transaksi->status }}</td>
                                                <td>
                                                    <a href="{{ route('mekanik.transaksi.detail', ['id_pelanggan' => $customer->id, 'id_transaksi' => $transaksi->id ]) }}" class="btn btn-xs btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                        Detail
                                                    </a>
                                                    @if ($transaksi->status == 'unpaid' && $transaksi->mekanik_id == Auth::user()->id)
                                                        <form action="{{ route('mekanik.transaksi.bypelanggan.delete', ['id_pelanggan' => $customer->id, 'id_transaksi' => $transaksi->id]) }}" style="display: inline-block;"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                onclick="return confirm('Yakin Ingin Hapus Data?')"
                                                                class="btn btn-xs btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
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
        <div class="row mt-1">
            <div class="col-3">
                <a href="{{ route('mekanik.transaksi.bypelanggan.create', ['id_pelanggan' => $customer->id]) }}"
                    class="btn btn-primary"><i class="fas fa-plus"></i>
                    TRANSAKSI BARU</a>
            </div>
        </div>
    </div>

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
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            });
        </script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    @endsection
</x-app-layout>
