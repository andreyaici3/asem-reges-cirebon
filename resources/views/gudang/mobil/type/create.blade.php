<x-app-layout menuActive="merk-mobil" menuOpen="car">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">TAMBAH TIPE MOBIL {{ strtoupper($merk->name) }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('gudang.mobil.merk') }}">Data Merk Mobil</a></li>
                <li class="breadcrumb-item active">Tambah Tipe Mobil</li>
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

                    <form method="POST" action="{{ route('gudang.mobil.type', ['id_merk' => $merk->id]) }}">
                        @csrf
                        <div class="card-body">
                            <div id="formSection"></div>
                            <div class="row mt-4">
                                <button type="button" class="btn btn-primary btn-sm" onclick="createField()">Tambah
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
                var section = document.getElementById("formSection");
                section.insertAdjacentHTML('beforeend', `
                    <div id="section-${no}">
        <h6><b>Field ${no}</b></h6>
        <div class="row" id="row-sec-${no}">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Jenis Mobil</label>
                    <input type="text" name="jenis[]" class="form-control" id="jenis_mobil[]" placeholder="Jenis Mobil" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Type Mobil</label>
                    <input type="text" name="tipe[]" class="form-control" id="tipe_mobil[]" placeholder="Tipe Mobil" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tahun Mobil</label>
                    <input type="number" name="tahun[]" class="form-control" id="tahun_mobil[]" placeholder="Tahun Mobil" required>
                </div>
            </div>

            <div class="col-md-3" id="btn-field-${no}">
                <div class="form-group">
                    <label>Hapus Field ${no}</label> <br>
                    <button class="btn-sm btn-primary" type="button" onclick="removeField(${no})">X</button>
                </div>
            </div>
        </div>
                `);


                if (no > 1) {
                    temp = no - 1;
                    var field = document.getElementById("btn-field-" + temp).remove();
                }
                no++
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
