<x-app-layout menuActive="service">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">Tambah Data Layanan {{ $layanan->service_name }} Untuk Mobil {{ strtoupper($jenis->name) }}
            </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('layanan') }}">Data Layanan</a></li>
                <li class="breadcrumb-item active">Tambah Sub Layanan</li>
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

                    <form method="POST" action="{{ route("sublayanan.store", ["id_layanan" => $layanan->id]) }}">
                        
                        @csrf
                        <div class="card-body">
                            <div id="formSection">

                            </div>
                            <div class="row mt-4">
                                <button type="button" onclick="createField()" class="btn btn-success btn-sm">Tambah
                                    Field</button>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            var no = 1;

            function createField() {
                var jenis = createElementJenis();
                var section = document.getElementById("formSection");
                section.insertAdjacentHTML("beforeend", `
                    <div id="section-${no}">
                                    <h6><b>Field ${no}</b></h6>
                                    <div class="row" id="row-sec-${no}">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Jenis Mobil</label>
                                                <select name="jenis[]" id="jenis[]" class="form-control">
                                                    ${jenis}
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Harga Jasa</label>
                                                <input type="number" name="jasa[]" class="form-control" id="jasa[]" placeholder="Harga Jasa" required value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Harga Jasa Khusus</label>
                                                <input type="number" name="jk[]" class="form-control" id="jk[]" placeholder="Harga Jasa Husus" required value="0">
                                            </div>
                                        </div>

                                        <div class="col-md-3" id="btn-field-${no}">
                                            <div class="form-group">
                                                <label>Hapus Field ${no}</label> <br>
                                                <button class="btn-sm btn-primary" type="button" onclick="removeField(${no})">X</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                `);

                if (no > 1) {
                    temp = no - 1;
                    var field = document.getElementById("btn-field-" + temp).remove();
                }
                no++;
            }

            function createElementJenis() {
                var jenis = <?= $jenis_mobil ?>;
                var html = [];

                for (var i = 0; i < jenis.length; i++) {
                    var row = jenis[i];
                    // var rows = jurusan[i];
                    html.push(`<option value="${row?.id}">${row?.jenis} - ${row?.tipe} - ${row?.tahun}</option>`);
                }
                return html.join();
            }

            function removeField(index) {
                var temp = index - 1;
                document.getElementById("section-" + index).remove();
                if (no > 1) {
                    var field = document.getElementById("row-sec-" + temp);
                    if (field != null) {
                        field.insertAdjacentHTML("beforeend", `
                        <div class="col-md-3" id="btn-field-${temp}">
                    <div class="form-group">
                        <label>Hapus Field ${temp}</label> <br>
                        <button class="btn-sm btn-primary" type="button" onclick="removeField(${temp})">X</button>
                    </div>
                </div>
                    `);
                    }

                    no--
                }
            }
        </script>
    @endsection
</x-app-layout>
