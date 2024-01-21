<x-app-layout menuActive="pelanggan" menuOpen="">
    @section('breadcrumb')
        <div class="col-sm-6">
            <h1 class="m-0">TRANSAKSI</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mekanik.pelanggan') }}">Data Customer</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('mekanik.transaksi.bypelanggan', ['id_pelanggan' => $customer->id]) }}">{{ $customer->name }}</a>
                </li>
                <li class="breadcrumb-item active">Invoice Transaksi</li>
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
                                <h4>
                                    <b>INVOICE PEMBAYARAN</b>
                                    <small class="float-right">Date:
                                        {{ Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y') }}</small>
                                </h4>
                            </div>

                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>Asem Reges Cirebon</strong><br>
                                    Cabang: {{ $transaksi->branch->branch->name }} <br>
                                    Alamat: {{ $transaksi->branch->branch->address }} <br>
                                    Phone: {{ $transaksi->branch->branch->phone }}<br>

                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{ $transaksi->customer->name }}</strong><br>
                                    Number Plat: {{ $transaksi->customer->number_plat }}<br>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #0000{{ $transaksi->id }}</b><br>
                                <br>
                                <b>Order ID:</b> {{ $transaksi->id }}<br>
                                <b>Payment Due:</b> -<br>
                                <b>Status:</b> -
                                @if ($transaksi->status == 'unpaid')
                                    <span class="badge badge-lg bg-danger">{{ strtoupper($transaksi->status) }}</span>
                                @elseif($transaksi->status == 'paid')
                                    <span class="badge badge-lg bg-success">{{ strtoupper($transaksi->status) }}</span>
                                @endif
                            </div>

                        </div>


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
                                                <td>Rp {{ number_format($value->selling, 2, ',', '.') }}</td>
                                                <td>Rp
                                                    {{ number_format($value->selling * $value->qty, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row mt-4">

                            <div class="col-6">
                                <p class="lead">Deskripsi Service:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $transaksi->description }}
                                </p>
                            </div>

                            <div class="col-6">
                                <p class="lead"><label for="">Total Pembayaran</label></p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>Rp {{ number_format($subtotal, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Jasa Service</th>
                                            <td>Rp {{ number_format($transaksi->price_service, 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td><span style="font-weight: bold;" class="totbyr">Rp
                                                    {{ number_format($transaksi->price_service + $subtotal, 2, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>


                        <div class="row no-print">
                            <div class="col-12">
                                @if ($transaksi->nota->id != null)
                                    <a target="_blank" href="{{ route('kasir.cetak.nota', ['id_nota' => $transaksi->nota->id]) }}"
                                        rel="noopener" target="_blank" class="btn btn-default"><i
                                            class="fas fa-print"></i> Print</a>
                                @endif


                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>





</x-app-layout>
