<x-app-layout menuActive="nonservice">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">Pembayaran Mekanik</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Bayar</li>
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

                    <div class="card-body">
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-globe"></i> Proses Pembayaran
                                        <small class="float-right">Date: {{ date('d-m-Y') }}</small>
                                    </h4>
                                </div>
                            </div>

                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    Kasir
                                    <address>
                                        <strong>{{ $data->kasir->name }}</strong><br>
                                        Email: <a href="" class="__cf_email__"
                                            data-cfemail="157c7b737a55747978746674707071666160717c7a3b767a78">[{{ $data->kasir->email }}]</a>
                                    </address>
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong>
                                            @if ($data->customer_id == null)
                                                UMUM
                                            @else
                                                {{ $data->customer->name }}
                                            @endif
                                        </strong>
                                    </address>
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #{{ $data->id }}</b><br>
                                </div>

                            </div>


                            <div class="row">
                                @if ($data->total_item != 0)
                                    @php
                                        $i = 1;
                                    @endphp
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama Produk</th>
                                                    <th>Harga</th>
                                                    <th>Qty</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->detail as $key => $value)
                                                    <tr>
                                                        <td>{{ $value->produk->name }}</td>
                                                        <td>{{ $value->produk->selling }}</td>
                                                        <td>{{ $value->qty }}</td>
                                                        <td>{{ number_format($value->qty * $value->produk->selling, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @if ($data->total_item != 0)
                                    <blockquote>
                                        Deskripsi Singkat <br>
                                        <h3>{{ $data->description }}</h3>
                                        <br>
                                        Price Service <br>
                                        <h4>Rp. {{ number_format($data->price_service, 0, ',', '.') }}</h4>
                                    </blockquote>
                                @else
                                    <blockquote>
                                        <h3>{{ $data->description }}</h3>
                                    </blockquote>
                                @endif
                            </div>

                            <div class="row">

                                <div class="col-lg-6 col-md-12">
                                    <p class="lead"><b>Estimasi Pengerjaan</b></p>

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        {{ $data->estimasi_pengerjaan }}
                                    </p>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <form action="{{ route('approv.bayar.submit', ['id_trx' => $data->id]) }}"
                                        method="post">
                                        @csrf
                                        <p class="lead">Total Pembayaran</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                @if ($data->total_item == 0)
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td><b class="sub-total">Rp.
                                                                {{ number_format($data->price_service, 0, ',', '.') }}</b>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td><b class="sub-total">Rp.
                                                                {{ number_format($data->price_service + $data->total_selling, 0, ',', '.') }}</b>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th>Diccount (%)</th>
                                                    <td><input type="number" name="discount" id=""
                                                            class="form-control"></td>
                                                </tr>
                                                @if ($data->total_item == 0)
                                                    <tr>
                                                        <th style="width:50%">Total Bayar:</th>
                                                        <td><b><span class="tot-byr">Rp
                                                                    {{ number_format($data->price_service, 0, ',', '.') }}</span></b>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th style="width:50%">Total Bayar:</th>
                                                        <td><b><span class="tot-byr">Rp
                                                                    {{ number_format($data->price_service + $data->total_selling, 0, ',', '.') }}</span></b>
                                                        </td>
                                                    </tr>
                                                @endif

                                                <tr>
                                                    <th>Jumlah Uang</th>
                                                    <td><input type="number" name="uang" id=""
                                                            class="form-control" value="0"></td>
                                                </tr>
                                                <tr>
                                                    <th class="ket-status">Kembalian</th>
                                                    <td><b><span class="kembali">Rp
                                                                {{ number_format('0', 2, ',', '.') }}</span></b></td>
                                                </tr>
                                            </table>
                                        </div>
                                </div>

                            </div>


                            <div class="row no-print">
                                <div class="col-12">

                                    <button type="submit" class="btn btn-success float-right"><i
                                            class="far fa-credit-card"></i> Simpan Pembayaran
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>

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
        <script>
            $(function() {
                var subTotal1 = 0;
                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4'
                })

                $("input[name=uang]").change(function() {
                    var uang = $(this).val();
                    let total = $(".tot-byr").html();
                    total = total.replace("&nbsp;", '');
                    total = total.replaceAll(/\s/g, '');
                    total = total.replace("Rp", "");
                    total = total.replaceAll(".", "");

                    total = total.replace(",00", "");
                    total = parseInt(total);
                    let kembali = uang - total;
                    let kmb = new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }).format(kembali);
                    $(".kembali").html(kmb);
                })

                $("input[name=discount]").change(function() {
                    var disc = $(this).val();
                    let total = $(".sub-total").html();
                    if (disc > 0 && disc <= 100) {
                        total = total.replace("Rp.", "");
                        total = total.trim();
                        total = total.replace(".", "");
                        total = total.replace(".", "");
                        total = parseInt(total);

                        disc = total * (disc / 100);
                        total = total - disc;

                        let toy = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }).format(total);
                        $(".tot-byr").html(toy);
                        let uang = $("input[name=uang]").val();
                        kembali = (uang - total);
                        if (kembali > 0) {
                            $(".ket-status").html("kembalian");
                        } else {
                            $(".ket-status").html("Uang Kurang");
                        }
                        let kmb = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }).format(kembali);
                        $(".kembali").html(kmb);
                    } else {
                        total = total.replace("Rp.", "Rp ");
                        $(".tot-byr").html(total);
                    }
                })
            })
        </script>
    @endsection

    @section('css')
        <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    @endsection

</x-app-layout>
