<x-app-layout menuActive="merk-mobil" menuOpen="car">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">DATA MERK MOBIL</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Merk Mobil</li>
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
                            <div class="col-3">
                                <button type="button" onclick="resetform()" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Merk
                                </button>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Merk Mobil</th>
                                            <th>Jumlah Tipe</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($merks as $merk)
                                            <tr>
                                                <td>{{ $nomor++ }}</td>
                                                <td>{{ $merk->name }}</td>
                                                <td>
                                                    <a href="{{ route('gudang.mobil.type', ['id_merk' => $merk->id]) }}"
                                                        class="btn btn-success btn-xs">{{ $merk->tipe->count() }} Tipe
                                                        Mobil</a>
                                                </td>
                                                <td>
                                                    <button value="{{ $merk->name }}" type="button"
                                                        onclick="edit(this.id, this.value)" id="{{ $merk->id }}"
                                                        class="btn btn-xs btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>|
                                                    <form
                                                    id="delete{{ $merk->id }}"
                                                        action="{{ route('gudang.mobil.merk.delete', ['id' => $merk->id]) }}"
                                                        style="display: inline-block;" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button"
                                                            onclick="confirmHapus(('{{ $merk->id }}'))"
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

    </div>

    <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Merk Mobil</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="myForm" action="{{ route('gudang.mobil.merk') }}">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="merk_mobil">Merk Mobil</label>
                            <input type="text" name="name"
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="merk_mobil"
                                placeholder="Masukan Merk Mobil" aria-describedby="merk_mobil-error"
                                aria-invalid="false" value="">
                            <span id="merk_mobil-error" class="error invalid-feedback">
                                {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
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
                    "buttons": []
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            });

            function resetform() {
                $("input[name=_method]").remove();
                var url = '{{ route('gudang.mobil.merk') }}';
                $("#myForm").attr("action", url);
                $("input[name=name]").val("");
                $("#modal-sm").modal("show");
            }

            function edit(id, name) {
                $("#modal-sm").modal("show");
                var url = '{{ route('gudang.mobil.merk.update', ['id' => ':id']) }}';
                url = url.replace(":id", id);
                $(".modal-body").append('{{ method_field('PUT') }}')
                $("#myForm").attr("action", url);
                $("input[name=name]").val(name);
            }

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
        </script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    @endsection
</x-app-layout>
