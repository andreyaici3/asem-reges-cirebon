<x-app-layout menuActive="merk" menuOpen="produk">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">DATA MERK PRODUK</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Merk Produk</li>
            </ol>
        </div>
    @endsection

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="form" method="POST" action="{{ route('admin.produk.merk') }}">
                            @csrf
                            <label for="merk_produk">Merk Produk</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="merk_produk"
                                    placeholder="Masukan Merk" aria-describedby="merk_produk-error" aria-invalid="false"
                                    value="{{ old('name') ?? @$merk->name }}">
                                <span id="merk_produk-error" class="error invalid-feedback">
                                    {{ $errors->has('name') ? '*) ' . $errors->first('name') : '' }}</span>
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-sm btn-flat" id="btn-merk-primary">
                                        Merk Baru</button>
                                    <span class="input-group-append ml-2">
                                        <button onclick="cancel_edit()" type="button" style="display: none;"
                                            class="btn btn-danger btn-sm" id="btn-merk-cancel">X </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Sub Merk</h3>
                    </div>
                    <div class="card-body">
                        <form id="form-sub" method="POST" action="{{ route('admin.produk.type') }}">
                            @csrf
                            <div class="form-group">
                                <label for="product_type">Merk</label>
                                <select class="form-control select2" style="width: 100%;" name="product_merk_id">
                                    @foreach ($merks as $merk)
                                        <option value="{{ $merk->id }}">{{ $merk->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="subName">Sub Merk</label>
                                <input type="text" name="subName"
                                    class="form-control {{ $errors->has('subName') ? 'is-invalid' : '' }}"
                                    id="subName" placeholder="Sub Merk" aria-describedby="subName-error"
                                    aria-invalid="false" value="{{ old('subName') ?? @$product->subName }}">
                                <span id="subName-error" class="error invalid-feedback">
                                    {{ $errors->has('subName') ? '*) ' . $errors->first('subName') : '' }}</span>
                            </div>

                            <button type="submit" id="btn-tambah-sub" class="btn btn-info btn-sm">Tambah Sub</button>
                            <button onclick="cancel_edit_sub()" type="button" style="display: none;"
                                class="btn btn-danger btn-sm" id="btn-tambah-sub-cancel">Batal </button>
                        </form>
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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Merk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $nomor = 1;
                                        @endphp
                                        @foreach ($merks as $merk)
                                            <tr>
                                                <td>{{ $nomor++ }}</td>
                                                <td>{{ $merk->name }}</td>
                                                <td>
                                                    <button onclick="show_detail(this)" type="button"
                                                        class="btn btn-xs btn-success" id="{{ $merk->id }}">Show
                                                        Detail</button>
                                                    <button
                                                        onclick="edit_merk('{{ $merk->id }}', '{{ $merk->name }}')"
                                                        type="button" str="{{ $merk->name }}"
                                                        ids="{{ $merk->id }}" class="btn btn-xs btn-primary"
                                                        id="{{ $merk->id }}">Edit</button>
                                                    <form id="deleteMerk{{ $merk->id }}"
                                                        action="{{ route('admin.produk.merk.delete', ['id_merk' => $merk->id]) }}"
                                                        method="post" style="display: inline-block;">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button onclick="hapusMerk(this)" type="button"
                                                            class="btn btn-xs btn-danger"
                                                            id="{{ $merk->id }}">Hapus</button>
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



        <div class="row">
            <div class="col-lg-12 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Sub Kategori</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Merk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="body-sub-kategori">

                            </tbody>
                        </table>
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
        <script src="/plugins/toastr/toastr.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                var gagal = '{{ Session::has('gagal') }}';
                var sukses = '{{ Session::has('sukses') }}';
                if (gagal) {
                    toastr.error('{{ session('gagal') }}')
                }

                if (sukses) {
                    toastr.success('{{ session('sukses') }}')
                }
            });

            function hapusMerk($this) {
                var id = $this.id;
                Swal.fire({
                    title: "Apakah Kamu Yakin?",
                    text: "Data Akan Dihapus",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Lanjutkan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#deleteMerk" + id).submit();
                    }
                });
            }

            function hapusSubMerk($this) {
                var id = $this.id;
                Swal.fire({
                    title: "Apakah Kamu Yakin?",
                    text: "Data Akan Dihapus",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Lanjutkan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#deleteSubMerk" + id).submit();
                    }
                });
            }

            $("#editMerk").click(function() {
                $("#batal-edit").show();
            })

            function edit_merk(id, str) {
                var urlAction = "{{ route('admin.produk.merk.update', ['id_merk' => ':id']) }}";
                var urlAction = urlAction.replace(":id", id)
                var put = '{{ method_field('PUT') }}';
                $("#btn-merk-primary").html("Simpan");
                $("#btn-merk-cancel").css("display", "block");
                $("input[name=name]").val(str)
                $("html, body").animate({
                    scrollTop: "0"
                });
                $("#form").attr("action", urlAction)
                $("#form").append(put);
                
            }

            function cancel_edit() {
                var urlActionDefault = '{{ route('admin.produk.merk') }}';
                $("#btn-merk-primary").html("Tambah");
                $("#btn-merk-cancel").css("display", "none");
                $("input[name=name]").val("")
                $("#form").attr("action", urlActionDefault)
                $("input[value=PUT]").remove();
            }


            function edit_sub_merk(merk_id, sub_merk_name, sub_merk_id) {
                var urlAction = '{{ route("admin.produk.type.update", ["id_merk" => ":merk", "id_type" => ":type"]) }}';
                urlAction = urlAction.replace(":merk", merk_id);
                urlAction = urlAction.replace(":type", sub_merk_id);
                $("select[name=product_merk_id] option[value='"+ merk_id +"']").prop("selected", true);
                $("html, body").animate({
                    scrollTop: "0"
                });
                $("input[name=subName]").val(sub_merk_name);
                $("#btn-tambah-sub").html("Simpan");
                $("#btn-tambah-sub-cancel").css("display", "inline-block")
                $("#form-sub").attr("action", urlAction)
                var put = '{{ method_field('PUT') }}';
                $("#form-sub").append(put);
            }

            function cancel_edit_sub(){
                var urlAction = "{{ route('admin.produk.type') }}";
                $("#form-sub").attr("action", urlAction)
                $("input[name=subName]").val("");
                $("#btn-tambah-sub").html("Tambah Sub");
                $("#btn-tambah-sub-cancel").css("display", "none");
                $("input[value=PUT]").remove();
            }


            function show_detail($this) {
                var base_url = "{{ URL::to('/') }}" + "/product/merk/" + $this.id + "/detail";
                $("select[name=product_merk_id] option[value='"+ $this.id +"']").prop("selected", true)
                $.ajax({
                    url: base_url,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        var len = data.length;
                        if (len > 0) {
                            
                            let html = "";
                            for (let i = 0; i < len; i++) {
                                var action = "{{ route('admin.produk.type.delete', ['id_merk' => ':merk', 'id_type'=> ':type']) }}";
                                action = action.replace(":merk", data[i].product_merk_id);
                                action = action.replace(":type", data[i].id);
                                var csrf = '{{ csrf_field() }}';
                                var method = '{{ method_field("DELETE") }}'
                                var params  = '"'+ data[i].product_merk_id + '", "' + data[i].name + '", "'+ data[i].id +'"';
                                html += "<tr>";
                                html += "<td>" + (i + 1) + "</td>";
                                html += "<td>" + data[i].name + "</td>";
                                html += "<td><button style='margin-right: 5px;' onclick='edit_sub_merk("+ params +")' class='btn btn-xs btn-primary'>Edit</button>";
                                html += "<form style='display: inline-block;' id='deleteSubMerk" + data[i].id + "' method='post' action='"+ action +"'>";
                                html += csrf;
                                html += method;
                                html += "<button onclick='hapusSubMerk(this)'' type='button' class='btn btn-xs btn-danger' id='"+ data[i].id +"'>Hapus</button>"
                                html += "</form>";
                                html += "</td>";
                                html += "</tr>";
                            }
                            $("#body-sub-kategori").html(html);
                        } else {
                            let html = "<tr><td colspan='3' class='text-center'>DATA TIDAK DITEMUKAN</td><tr>";
                            $("#body-sub-kategori").html(html);
                        }
                    }
                })
            }
        </script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    @endsection
</x-app-layout>
