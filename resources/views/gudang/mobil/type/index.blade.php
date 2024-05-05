<x-app-layout menuActive="merk-mobil" menuOpen="car">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">JENIS MOBIL - {{ strtoupper($merk->name) }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Type Mobil</li>
            </ol>
        </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row mt-4">
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
                                            <th>Jenis Mobil</th>
                                            <th>Tipe Mobil</th>
                                            <th>Tahun</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($types as $type)
                                            <tr>
                                                <td>{{ $nomor++ }}</td>
                                                <td>{{ $type->jenis }}</td>
                                                <td>{{ $type->tipe }}</td>
                                                <td>{{ $type->tahun }}</td>
                                                <td>
                                                    <button type="button" onclick="edit(this)" data-jenis="{{ $type->jenis }}" data-tipe="{{ $type->tipe }}" data-tahun="{{ $type->tahun }}" data-id="{{ $type->id }}"
                                                        class="btn btn-xs btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>|
                                                    <form id="delete{{ $type->id }}"
                                                        action="{{ route('gudang.mobil.type.delete', ['id_type' => $type->id, 'id_merk' => $merk->id]) }}"
                                                        style="display: inline-block;" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button"
                                                            onclick="confirmHapus('{{ $type->id }}')"
                                                            class="btn btn-xs btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                            Hapus
                                                        </button>
                                                    </form>
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
                <a href="{{ route('gudang.mobil.type.create', ['id_merk' => $merk->id]) }}" class="btn btn-primary"><i
                        class="fas fa-plus"></i> JENIS BARU</a>
            </div>
        </div>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Jenis Mobil</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" id="myForm" action="{{ route('gudang.mobil.merk') }}">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="merk_mobil">Jenis Mobil</label>
                                <input type="text" name="jenis"
                                    class="form-control {{ $errors->has('jenis') ? 'is-invalid' : '' }}" id="merk_mobil"
                                    aria-describedby="merk_mobil-error"
                                    aria-invalid="false" required>
                                <span id="merk_mobil-error" class="error invalid-feedback">
                                    {{ $errors->has('jenis') ? '*) ' . $errors->first('jenis') : '' }}</span>
                            </div>
                            <div class="form-group">
                                <label for="merk_mobil">Tipe Mobil</label>
                                <input type="text" name="tipe"
                                    class="form-control {{ $errors->has('tipe') ? 'is-invalid' : '' }}" id="merk_mobil"
                                     aria-describedby="merk_mobil-error"
                                    aria-invalid="false">
                                <span id="merk_mobil-error" class="error invalid-feedback">
                                    {{ $errors->has('tipe') ? '*) ' . $errors->first('tipe') : '' }}</span>
                            </div>
                            <div class="form-group">
                                <label for="merk_mobil">Tahun</label>
                                <input type="text" name="tahun"
                                    class="form-control {{ $errors->has('tahun') ? 'is-invalid' : '' }}" id="merk_mobil"
                                    aria-describedby="merk_mobil-error"
                                    aria-invalid="false">
                                <span id="merk_mobil-error" class="error invalid-feedback">
                                    {{ $errors->has('tahun') ? '*) ' . $errors->first('tahun') : '' }}</span>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
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

            function confirmHapus(id) {
                Swal.fire({
                    title: "Apakah Kamu Yakin ?",
                    text: "Data akan dihapus dan tidak akan dapat dikembalikan",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#delete" + id).submit();
                    }
                });
            }

            function edit($this) {
                $("#modal-default").modal("show");
                var data = $this.dataset;
                $("input[name=jenis]").val(data.jenis);
                $("input[name=tipe]").val(data.tipe);
                $("input[name=tahun]").val(data.tahun);
                var url = '<?= route('gudang.mobil.type.update', ['id_merk' => ':id_merk', 'id_type' => ':id_type']) ?>';
                var id_merk = "<?= $merk->id ?>";
                var id_type = data.id;
                url = url.replace(":id_type", id_type);
                url = url.replace(":id_merk", id_merk);
                $(".modal-body").append('{{ method_field('PUT') }}')
                $("#myForm").attr("action", url);
            }   
        </script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    @endsection
</x-app-layout>
