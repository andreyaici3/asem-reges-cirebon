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
                                <form
                                    action="{{ route('mekanik.transaksi.bypelanggan.min', ['id_pelanggan' => 1, 'code' => $cart['code']]) }}"
                                    style="display: inline-block;" method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit" class="btn btn-xs btn-primary">
                                        <i class="fas fa-window-minimize"></i>

                                    </button>
                                </form> |
                            @endif
                            <form
                                action="{{ route('mekanik.transaksi.bypelanggan.trash', ['id_pelanggan' => 1, 'code' => $cart['code']]) }}"
                                style="display: inline-block;" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" onclick="return confirm('yakin ingin hapus produk.?')"
                                    class="btn btn-xs btn-danger">
                                    <i class="fas fa-trash"></i>

                                </button>
                            </form> |
                            <form
                                action="{{ route('mekanik.transaksi.bypelanggan.plus', ['id_pelanggan' => 1, 'code' => $cart['code']]) }}"
                                style="display: inline-block;" method="POST">
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

    <div class="form-group">
        <form action="" method="post">
            @csrf
            <label for="merk_mobil">Masukan / Scan Kode Barang</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Kode Barang" name="code_barang">
                <div class="input-group-prepend">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <span style="margin-left: 10px;"></span>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                        Cari Barang
                    </button>
                </div>
            </div>
        </form>
    </div>

    <input type="hidden" name="kasir_mode" value="true">
    <div class="form-group">
        <label>Deskripsi Singkat</label>
        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukan Catatan Keluhan Disini">{{ old('deskripsi') }}</textarea>
    </div>

    <div class="form-group">
        <label for="estimasi_jasa_pasang">Estimasi Jasa</label>
        <input type="number" name="price_service"
            class="form-control {{ $errors->has('price_service') ? 'is-invalid' : '' }}" id="estimasi_jasa_pasang"
            placeholder="Jasa Service" aria-describedby="estimasi_jasa_pasang-error" aria-invalid="false"
            value="{{ old('price_service') ?? 0 }}">
        <span id="estimasi_jasa_pasang-error" class="error invalid-feedback">
            {{ $errors->has('price_service') ? '*) ' . $errors->first('price_service') : '' }}</span>
    </div>

    <div class="form-group">
        <label for="customer">Customer</label>
        <select class="form-control select2" style="width: 100%;" name="customer_id">
            <option value="null">-- Customer --</option>
            @foreach ($customer as $value)
                <option value="{{ $value->id }}">
                    {{ $value->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="keterangan">Est. Pengerjaan</label>
        <input type="text" name="estimasi_pengerjaan"
            class="form-control {{ $errors->has('price_service') ? 'is-invalid' : '' }}" id="keterangan"
            placeholder="Ex. 1 Hari, Selesai Hari Ini dll" aria-describedby="keterangan-error" aria-invalid="false"
            value="">
        <span id="keterangan-error" class="error invalid-feedback">
            {{ $errors->has('price_service') ? '*) ' . $errors->first('price_service') : '' }}</span>
    </div>



    <div class="row justify-content-end">
        <div class="col-lg-6 mt-4 col-sm-12">
            <p class="lead"><label for="">Total Pembayaran</label></p>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Rp {{ number_format($subtotal, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Jasa Service</th>
                        <td><span class="jasasrv">Rp. 0</span></td>
                    </tr>
                   
                    <tr>
                        <th>Est. Total:</th>
                        <td><span style="font-weight: bold;" class="totbyr">Rp
                                {{ number_format($subtotal, 2, ',', '.') }}</span></td>
                    </tr>
                   
                    
                 
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="button" class="btn btn-primary btn-simpan">Simpan Transaksi</button>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" name="getproduk">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Daftar Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="product_master">Produk</label>
                        <select class="form-control select2" style="width: 100%;" name="product">
                            <option value="code">-- SIlahakan Cari Produk --</option>
                            @foreach ($product as $value)
                                <option value="{{ $value->code }}">
                                    {{ $value->code }} - {{ $value->name }} - ( @for ($i = 0; $i < count($value->available); $i++)
                                        {{ $value->available[$i]->tipe->name }}{{ $i != count($value->available) - 1 ? ', ' : '' }}
                                    @endfor)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_master">Keterangan</label>
                        <p>Kode Barang: <span class="code"></span><br>
                            Harga: <span class="harga"></span> <br>
                            Vendor: <span class="vendor"> </span><br>
                            Stok: <span class="stoks"> </span><br>
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary pilih-produk">Pilih</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    <script src="/plugins/jquery/jquery.min.js"></script>

    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            var subTotal1 = 0;
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            })
            $("select[name=product]").change(function() {
                var code = $(this).val();
                var url =
                    '{{ route('api.getproduk', ['code' => ':codes']) }}',
                    url = url.replace(':codes', code);

                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data.stok)
                        var action =
                            '{{ route('mekanik.transaksi.bypelanggan.add', ['code' => ':codes', 'id_pelanggan' => 1]) }}'
                        action = action.replace(':codes', code);
                        $("span[class=code]").html(data.code);
                        $("span[class=harga]").html(data.selling);
                        $("span[class=vendor]").html(data.vendor.name);
                        $("span[class=tipe]").html(data.tipename);
                        $("span[class=stoks]").html(data.stok);
                        $("form[name=getproduk]").attr("action", action);

                    }
                })
            })
            $(".btn-simpan").click(function() {
                Swal.fire({
                    title: "Konfirmasi Transaksi",
                    text: "Dengan Klik Ok, Data Tidak Dapat Diubah Kembali",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $("select[name=customer_id]").val();
                        var action =
                            '{{ route('mekanik.transaksi.bypelanggan.store', ['id_pelanggan' => ':idpelanggan']) }}';
                        if (id == "null") {
                            id = 0;
                        }
                        action = action.replace(":idpelanggan", id);
                        var url = "<form id='myForm' action='" + action + "' method='post'></form>";
                        var form = $('#myForm').children().unwrap().wrapAll(url);
                        $(".btn-simpan").attr("type", "submit");
                        $("#myForm").submit();

                    }
                });

            })

            $("input[name=price_service]").keyup(function() {
                var jasa = $(this).val();
                var sub = {{ $subtotal }};
                var totalBayar = parseInt(jasa) + parseInt(sub);
                var rp = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(totalBayar);

                var jasaSrv = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(jasa);

                $(".jasasrv").html(jasaSrv);
                $(".totbyr").html(rp);
                subTotal1 = totalBayar;
                var uangInput = $("input[name=jmlBayar]").val();
                var kembalian =parseInt(uangInput) -  parseInt(totalBayar);
                var kmb = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(kembalian);

                $(".kembali").html(kmb);
            })

            $("input[name=jmlBayar]").keyup(function() {
                var jml = $(this).val();

                var total = subTotal1;

                var kembalian = parseInt(jml) - parseInt(total);

                var kmb = new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(kembalian);

                $(".kembali").html(kmb);

            })
        });
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
