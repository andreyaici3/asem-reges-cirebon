<x-app-layout menuActive="transaksi">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">PEMBAYARAN TRANSAKSI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Data Transaksi</li>
                <li class="breadcrumb-item active">Bayar</li>
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
                            <div class="col-md-6 col-sm-12">
                                <div class="callout callout-info">
                                    <address>
                                        <strong>{{ $transaksi->customer->name }}</strong><br>
                                        Number Plat: {{ $transaksi->customer->number_plat }}<br>
                                        Keterangan: {{ $transaksi->description }} <br>
                                        Jasa Service: Rp {{ number_format($transaksi->price_service, 2, ',', '.') }}
                                        <br><br>
                                        <h3><b>Total: Rp
                                                {{ number_format($transaksi->total_purchased, 2, ',', '.') }}</b></h3>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="callout callout-info">
                                    <address>
                                        <h3>Kembalian</h3>
                                        <br>
                                        <h1><b><span class="kembali">Rp {{ number_format('0', 2, ',', '.') }}</span></b>
                                        </h1>
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">


                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Qty</th>
                                                            <th>Kode Produk</th>
                                                            <th>Nama produk</th>
                                                            <th>Harga</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $subtotal = 0;

                                                        @endphp
                                                        @foreach ($transaksi->detail as $value)
                                                            @php
                                                                $subtotal += $value->selling * $value->qty;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $value->qty }}</td>
                                                                <td>{{ $value->product_master_code }}</td>
                                                                <td>{{ $value->produk->name }}</td>
                                                                <td>Rp
                                                                    {{ number_format($value->selling, 2, ',', '.') }}
                                                                </td>
                                                                <td>Rp
                                                                    {{ number_format($value->selling * $value->qty, 2, ',', '.') }}
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
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 justify-content-right">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <form
                                                            action="{{ route('kasir.bayar.proses', ['id_transaksi' => $transaksi->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('put')
                                                            <tr>
                                                                <th style="width:50%">Jumlah Bayar</th>
                                                                <td>
                                                                    <input type="number" name="jmlBayar"
                                                                        class="form-control {{ $errors->has('jmlBayar') ? 'is-invalid' : '' }}"
                                                                        id="jmlBayar" placeholder="Masukan Jumlah Uang"
                                                                        aria-describedby="jmlBayar-error"
                                                                        aria-invalid="false"
                                                                        value="{{ old('jmlBayar') ?? @$merk->jmlBayar }}">
                                                                    <span id="jmlBayar-error"
                                                                        class="error invalid-feedback">
                                                                        {{ $errors->has('jmlBayar') ? '*) ' . $errors->first('jmlBayar') : '' }}</span>
                                                                </td>




                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <button type="submit" class="btn btn-primary"> <i
                                                                            class="fas fa-money-bill-alt"></i>
                                                                        Bayar</button>
                                                                </td>
                                                            </tr>
                                                        </form>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @section('js')
        <script src="/plugins/jquery/jquery.min.js"></script>

        <script>
            $(function() {
                $("input[name=jmlBayar]").keyup(function() {
                    var jml = $(this).val();

                    var total = {{ $transaksi->total_purchased }};

                    var kembalian = parseInt(jml) - parseInt(total);

                    var kmb = new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }).format(kembalian);

                    $(".kembali").html(kmb);

                })
            })
        </script>
    @endsection
</x-app-layout>
