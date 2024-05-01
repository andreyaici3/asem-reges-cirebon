@php
    if ($mode == 'trx') {
        $act = 'transaksi';
        $ket = 'Belum Dibayar';
    } else {
        $act = 'riwayat';
        $ket = 'Sudah Dibayar';
    }
@endphp

<x-app-layout menuActive="{{ $act }}">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">DATA SERVICE</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Data Service</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>Rp {{ number_format($transaksis->sum('total_purchased'), 2, ',', '.') }}</h3>
                        <p>{{ $ket }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
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
                                            <th>ID Trx - Tanggal</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Plat Nomor</th>
                                            <th>Nama Mekanik</th>
                                            <th>Jumlah Bayar</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $nomor = 1;
                                        @endphp
                                        @foreach ($transaksis as $transaksi)
                                            <tr>
                                                <td>{{ $nomor++ }}</td>
                                                <td>#{{ $transaksi->id }} -
                                                    {{ Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    @if (@$transaksi->customer->name != null)
                                                        {{ @$transaksi->customer->name }}
                                                    @else
                                                        Pelanggan Umum
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (@$transaksi->customer->number_plat != null)
                                                        {{ @$transaksi->customer->number_plat }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (@$transaksi->mekanik->name != null)
                                                        {{ @$transaksi->mekanik->name }}
                                                    @else
                                                        - (Menunggu Mekanik)
                                                    @endif
                                                </td>
                                                <td>Rp
                                                    {{ number_format($transaksi->total_selling + $transaksi->price_service, 2, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="btn 
                                                        @php
if ($transaksi->status == "estimate"){
                                                                echo "btn-success";
                                                            } else {
                                                                echo "btn-primary";
                                                            } @endphp
                                                    
                                                     btn-xs">{{ $transaksi->status }}</span>
                                                </td>
                                                <td>
                                                    @if ($transaksi->status == 'unpaid')
                                                        
                                                    @elseif($transaksi->status == 'progress')                                                        
                                                        <a href="{{ route('approv.bayar', ['id_trx' => $transaksi->id]) }}"
                                                            class="btn btn-warning btn-sm"><i
                                                                class="fas fa-user-check"></i> Bayar</a>
                                                    @elseif($transaksi->status == 'estimate')
                                                        <a target="_blank" href=""
                                                            class="btn btn-success btn-sm"><i class="fas fa-print"></i>
                                                            Doc. Mekanik</a>
                                                        <a href="{{ route('approv', ['id_trx' => $transaksi->id]) }}"
                                                            class="btn btn-primary btn-sm"><i
                                                                class="fas fa-user-check"></i> Approval</a>
                                                    @elseif($transaksi->status == 'paid')
                                                        <a target="_blank"
                                                            href="{{ route('kasir.cetak.nota', ['id_nota' => $transaksi->nota->id]) }}"
                                                            class="btn btn-success btn-sm"><i class="fas fa-print"></i>
                                                            Cetak Ulang Nota</a>
                                                        <a href="" class="btn btn-primary btn-sm"><i
                                                                class="fas fa-eye"></i> Detail</a>
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
