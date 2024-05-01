<x-app-layout menuActive="nonservice">
    @section('breadcrumb')
    <div class="col-sm-6">
        <h1 class="m-0">Approval Mekanik</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Tambah Transaksi</li>
        </ol>
    </div><!-- /.col -->
    @endsection

    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                @if (Session::has('sukses'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Selamat!</h5>
                    {{ session('sukses') }}
                </div>
                @endif

                @if (Session::has('gagal'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Oopss!</h5>
                    {{ session('gagal') }}
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Mohon Pastikan Kembali Data Sebelum Di Approv</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>No</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    @php
                                    $nomor = 1;
                                    $index = 0;
                                    $subtotal = 0;
                                    @endphp
                                    @foreach ($carts as $cart)
                                    @php
                                    $subtotal += $cart['qty'] * $cart['selling'];
                                    @endphp
                                    <tr>
                                        <td>{{ $nomor++ }}</td>
                                        <td>{{ $cart['code'] }}</td>
                                        <td>{{ $cart['name'] }}</td>
                                        <td>Rp. {{ number_format($cart['selling']) }}</td>
                                        <td>{{ $cart['qty'] }}</td>
                                        <td>Rp. {{ number_format($cart['qty'] * $cart['selling']) }}</td>
                                        <td>
                                            @if ($cart['qty'] > 1)
                                            <form action="{{ route('mekanik.transaksi.bypelanggan.min', ['id_pelanggan' => 1, 'code' => $cart['code']]) }}" style="display: inline-block;" method="POST">
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="btn btn-xs btn-primary">
                                                    <i class="fas fa-window-minimize"></i>

                                                </button>
                                            </form> |
                                            @endif
                                            <form action="{{ route('mekanik.transaksi.bypelanggan.trash', ['id_pelanggan' => 1, 'code' => $cart['code']]) }}" style="display: inline-block;" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('yakin ingin hapus produk.?')" class="btn btn-xs btn-danger">
                                                    <i class="fas fa-trash"></i>

                                                </button>
                                            </form> |
                                            <form action="{{ route('mekanik.transaksi.bypelanggan.plus', ['id_pelanggan' => 1, 'code' => $cart['code']]) }}" style="display: inline-block;" method="POST">
                                                @csrf
                                                @method('put')
                                                <button type="submit" onclick="" class="btn btn-xs btn-primary">
                                                    <i class="fas fa-plus"></i>

                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <form action="" method="post" id="myForm">
                                @method('put')
                                @csrf
                                <div class="form-group">
                                    <label for="mekanik">Pilih Mekanik</label>
                                    <select class="form-control select2" style="width: 100%;" name="mekanik_id">
                                        @foreach ($mekanik as $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi Singkat</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukan Catatan Keluhan Disini">{{ $data->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="estimasi_jasa_pasang">Estimasi Jasa</label>
                                    <input type="number" name="price_service" class="form-control {{ $errors->has('price_service') ? 'is-invalid' : '' }}" id="estimasi_jasa_pasang" placeholder="Jasa Service" aria-describedby="estimasi_jasa_pasang-error" aria-invalid="false" value="{{ old('price_service') ?? $data->price_service }}">
                                    <span id="estimasi_jasa_pasang-error" class="error invalid-feedback">
                                        {{ $errors->has('price_service') ? '*) ' . $errors->first('price_service') : '' }}</span>
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Est. Pengerjaan</label>
                                    <input type="text" name="estimasi_pengerjaan" class="form-control {{ $errors->has('price_service') ? 'is-invalid' : '' }}" id="keterangan" placeholder="Ex. 1 Hari, Selesai Hari Ini dll" aria-describedby="keterangan-error" aria-invalid="false" value="{{ $data->estimasi_pengerjaan }}">
                                    <span id="keterangan-error" class="error invalid-feedback">
                                        {{ $errors->has('price_service') ? '*) ' . $errors->first('price_service') : '' }}</span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" onclick="confirm()">Approv</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
    <script src="/plugins/jquery/jquery.min.js"></script>

    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        
        $(function() {
            var subTotal1 = 0;
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        })

        function confirm() {
            Swal.fire({
                title: "Konfirmasi",
                text: "Apakah Data Sudah Sesuai?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Konfirmasi"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $("#myForm").submit();
                }
            });
        }
    </script>

    @endsection



    @section('css')
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    @endsection

</x-app-layout>