<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota</title>
    <style type="text/css">
        @page {
            margin: 0
        }

        body {
            margin: 0;
            font-size: 10px;
            font-family: monospace;
        }

        td {
            font-size: 10px;
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.struk .sheet {
            width: 58mm;
        }

        body.struk .sheet {
            padding: 2mm;
        }

        .txt-left {
            text-align: left;
        }

        .txt-center {
            text-align: center;
        }

        .txt-right {
            text-align: right;
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0;
                font-family: monospace;
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body {
                font-family: monospace;
            }

            body.struk {
                width: 58mm;
                text-align: left;
            }

            body.struk .sheet {
                padding: 2mm;
            }

            .txt-left {
                text-align: left;
            }

            .txt-center {
                text-align: center;
            }

            .txt-right {
                text-align: right;
            }
        }
    </style>
</head>

<body class="struk" onload="printOut()">
    <section class="sheet">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td>{{ $nota->transaksi->branch->branch->name }}</td>
            </tr>
            <tr>
                <td>{{ $nota->transaksi->branch->branch->address }}</td>
            </tr>
            <tr>
                <td>Telp: {{ $nota->transaksi->branch->branch->phone }}</td>
            </tr>
        </table>
        {{ str_repeat('=', '37') }}
        <br>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td>Nota</td>
                <td>:</td>
                <td>#{{ $nota->transaction_id }}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>:</td>
                <td>{{ $nota->transaksi->kasir->name }}</td>
            </tr>
            <tr>
                <td>Tgl.</td>
                <td>:</td>
                <td>{{ Carbon\Carbon::parse($nota->created_at)->format('d-m-Y h:i:s') }}</td>
            </tr>
            <tr>
                <td colspan="3">
                    @if (isset($nota->transaksi->customer->id))
                        [{{ @$nota->transaksi->customer->id }}] {{ @$nota->transaksi->customer->name }}
                    @else
                        [UMUM] - Tanpa Nama
                    @endif
                </td>
            </tr>
        </table>
        <br>
        @php
            $tItem = 'Item' . str_repeat('&nbsp;', 12 - strlen('Item'));
            $tQty = 'Qty' . str_repeat('&nbsp;', 6 - strlen('Qty'));
            $tHarga = str_repeat('&nbsp;', 9 - strlen('Harga')) . 'Harga';
            $tTotal = str_repeat('&nbsp;', 10 - strlen('Total')) . 'Total';
            $caption = $tItem . $tQty . $tHarga . $tTotal;
        @endphp
        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td align="left" class="txt-left">
                    {!! $caption !!}
                </td>
            </tr>
            <tr>
                <td align="left" class="txt-left">
                    {{ str_repeat('=', 38) }}
                </td>
            </tr>
            @foreach ($nota->transaksi->detail as $value)
                <tr>
                    <td align="left" class="txt-left">
                        @php
                            echo $value->produk->name;
                            echo str_repeat('&nbsp;', 5);
                            echo $value->qty;
                            echo str_repeat('&nbsp;', 5);
                            echo number_format($value->selling, '0', ',', '.');
                            echo str_repeat('&nbsp;', 5);
                            echo number_format($value->selling * $value->qty, '0', ',', '.');
                        @endphp

                    </td>

                </tr>
            @endforeach

        </table>
        {{ str_repeat('-', '37') }}
        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td class="txt-left">
                    Sub Total
                </td>
                <td class="txt-right">
                    {{ number_format($value->transaksi->total_selling) }}
                </td>
            </tr>
            <tr>
                <td class="txt-left">
                    Jasa Service
                </td>
                <td class="txt-right">
                    {{ number_format($value->transaksi->price_service) }}
                </td>
            </tr>
            <tr>
                <td class="txt-left">
                    Grand Total
                </td>
                <td class="txt-right">
                    {{ number_format($value->transaksi->total_purchased) }}
                </td>
            </tr>
            <tr>
                <td class="txt-left">
                    Bayar
                </td>
                <td class="txt-right">
                    {{ number_format($nota->payment_amount) }}
                </td>
            </tr>
            <tr>
                <td class="txt-left">
                    Kembali
                </td>
                <td class="txt-right">
                    {{ number_format($nota->change_money) }}
                </td>
            </tr>
        </table>
        <br>
        @php
            $footer = 'Terima kasih atas kunjungan anda';
            $starSpace = (32 - strlen($footer)) / 2;
            $starFooter = str_repeat('*', $starSpace + 1);
            echo $starFooter . '&nbsp;' . $footer . '&nbsp;' . $starFooter . '<br/><br/><br/><br/>';
            echo '<p>&nbsp;</p>';
        @endphp
    </section>
    <script>
        var lama = 1000;
        t = null;

        function printOut() {
            window.print();
            t = setTimeout("self.close()", lama);
        }
    </script>
</body>

</html>
