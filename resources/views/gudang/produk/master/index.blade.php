<x-app-layout menuActive="master" menuOpen="produk">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">DATA MASTER PRODUK</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Master Produk</li>
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
                                            <th>Vendor</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Merk - Tipe</th>
                                            <th>Jumlah Stok</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Kompatibel</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($masters as $master)
                                            <tr>
                                                <td>{{ $nomor++ }}</td>
                                                <td>{{ $master->vendor->name }}</td>
                                                <td>{{ $master->code }}</td>
                                                <td>{{ $master->name }}</td>
                                                <td>{{ $master->tipe_produk->merk->name }} - {{ $master->tipe_produk->name }}</td>
                                                <td>{{ $master->stok }}</td>
                                                <td>Rp. {{ number_format($master->price) }}</td>
                                                <td>Rp. {{ number_format($master->selling) }}</td>
                                                <td>
                                                    @for($i = 0; $i < count($master->available); $i++)
                                                        {{ $master->available[$i]->tipe->name  }}{{ ($i!=count($master->available) - 1) ? ", " : "" }}
                                                    @endfor
                                                    
                                                </td>
                                                <td>
                                                    <a href="{{ route('gudang.produk.master.edit', ['id' => $master->id]) }}" class="btn btn-xs btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </a>|
                                                    <form action="{{  route('gudang.produk.master.delete', ['id' => $master->id]) }}" style="display: inline-block;" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            onclick="return confirm('Yakin Ingin Hapus Data?')"
                                                            class="btn btn-xs btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                            Hapus
                                                        </button>
                                                    </form>|
                                                     <a href="{{ route('master.produk.generate', ['code' => $master->code]) }}" class="btn btn-xs btn-primary">
                                                        <i class="fas fa-bars"></i>
                                                        BARCODE
                                                    </a>
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
                <a href="{{ route('gudang.produk.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                    PRODUK BARU</a>
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
