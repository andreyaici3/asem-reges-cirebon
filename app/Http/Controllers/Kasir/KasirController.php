<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MasterProduk;
use App\Models\Nota;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index()
    {
        @$chief_id = Auth::user()->employe->chief_id;

        return view('kasir.index', [
            "mode" => "trx",
            'transaksis' => Transaction::where([
                ['chief_id', "=", $chief_id],
                ['status', '!=', 'paid'],
                ['status', '!=', 'canceled'],
            ])->get(),
        ]);
    }

    public function bayarApproval($id_trx)
    {
        return view("kasir.transaksi.bayar", [
            "mekanik" => User::where("role", "mekanik")->get(),
            "data" => Transaction::findOrFail($id_trx),
        ]);
    }

    public function putApproval(Request $request, $id)
    {
        $transaksi = Transaction::findOrFail($id);
        if ($transaksi->total_item == 0) {
            $transaksi->update([
                "mekanik_id" => $request->mekanik_id,
                "description" => $request->deskripsi,
                "price_service" => $request->price_service,
                "estimasi_pengerjaan" => $request->estimasi_pengerjaan,
                "status" => "progress"
            ]);
            return redirect()->to(route("kasir"))->with("sukses", "Transaksi Berhasil Di Approve");
        } else {
            //mengembalikan stok ke semula
            foreach ($transaksi->detail as $key => $value) {
                $qtyAwal = MasterProduk::where("code", $value->product_master_code);
                $qtyAkhir = $value->qty + $qtyAwal->first()->stok;
                $qtyAwal->update([
                    "stok" => $qtyAkhir
                ]);
            }

            //hapus semua detail
            TransactionDetail::where("transaction_id", $transaksi->id)->delete();

            // update tabel detail
            $totalHargaBeli = 0;
            $totalHargaJual = 0;
            $totalItem = 0;

            $produks = session()->get('cart', []);
            foreach ($produks as $produk) {
                TransactionDetail::create([
                    "transaction_id" => $transaksi->id,
                    "product_master_code" => $produk["code"],
                    "price" => $produk["price"],
                    "selling" => $produk["selling"],
                    "qty" => $produk["qty"]
                ]);
                $totalHargaBeli += ($produk["price"] * $produk["qty"]);
                $totalHargaJual += ($produk["selling"] * $produk["qty"]);
                $totalItem += $produk["qty"];

                $MP = MasterProduk::where('code', $produk['code']);
                $stok_lama = $MP->first()->stok;
                $stok_baru = $stok_lama - $produk["qty"];
                MasterProduk::where('code', $produk['code'])->update([
                    "stok" => $stok_baru,
                ]);
            }

            $transaksi->update([
                "total_price" => $totalHargaBeli,
                "total_selling" => $totalHargaJual,
                "total_purchased" => $totalHargaJual + $request->price_service,
                "total_item" => $totalItem,
                "mekanik_id" => $request->mekanik_id,
                "description" => $request->deskripsi,
                "price_service" => $request->price_service,
                "estimasi_pengerjaan" => $request->estimasi_pengerjaan,
                "status" => "progress"
            ]);

            session()->forget("cart");
            session()->forget("edit");
            return redirect()->to(route("kasir"))->with("sukses", "Transaksi Berhasil Di Approve");
        }
    }

    public function submitBayar(Request $request, $id_trx)
    {
        //cek trx jasa / bukan
        $transaksi = Transaction::findOrFail($id_trx);
        if ($transaksi->total_item == 0) {
            //ubah harga dengan diskon
            if ($request->discount > 0 && $request->discount <= 100) {
                //hitung price service
                $price = $transaksi->price_service - ($request->discount / 100 * $transaksi->price_service);
            } else {
                $price = $transaksi->price_service;
            }
            $transaksi->update([
                'status' => "paid",
                "price_service" => $price
            ]);

            Nota::create([
                "transaction_id" => $transaksi->id,
                "total_payment" => $price,
                "payment_amount" => $request->uang,
                "change_money" => ($request->uang - $price),
                "discount" => $request->discount,
            ]);
            return redirect()->to(route("kasir"))->with("sukses", "Transaksi Berhasil Di Bayar");
        } else {
            $total = $transaksi->total_selling + $transaksi->price_service;
            if ($request->discount > 0 && $request->discount <= 100) {
                //hitung price service
                $price = $total - ($request->discount / 100 * $total);
            } else {
                $price = $total;
            }
            $transaksi->update([
                'status' => "paid",
                "total_purchased" => $price,
            ]);
            Nota::create([
                "transaction_id" => $transaksi->id,
                "total_payment" => $price,
                "payment_amount" => $request->uang,
                "change_money" => ($request->uang - $price),
                "discount" => $request->discount ?? 0,
            ]);
            return redirect()->to(route("kasir"))->with("sukses", "Transaksi Berhasil Di Bayar");
        }
    }

    public function approval($id_trx)
    {
        $trx = Transaction::findOrFail($id_trx);
        if ($trx->total_item == 0) {
            //trx jasa
            return view("kasir/transaksi/acc", [
                "data" => $trx,
                "mekanik" => User::where("role", "mekanik")->get()
            ]);
        } else {
            // trx non jasa
            //cek session trx yang di ewdit
            $sess = session()->get("edit");

            if (!$sess) {
                $sess = session()->put("edit", $id_trx);
                foreach ($trx->detail as $value) {
                    $cart[$value->product_master_code] = [
                        "code" => $value->product_master_code,
                        "name" => $value->produk->name,
                        "qty" => $value->qty,
                        "price" => $value->price,
                        "selling" => $value->selling,
                    ];
                }
                session()->put('cart', $cart);
            } else {
                if ($sess != $id_trx) {
                    $sess = session()->put("edit", $id_trx);
                    foreach ($trx->detail as $value) {
                        $cart[$value->product_master_code] = [
                            "code" => $value->product_master_code,
                            "name" => $value->produk->name,
                            "qty" => $value->qty,
                            "price" => $value->price,
                            "selling" => $value->selling,
                        ];
                    }
                    session()->put('cart', $cart);
                }
            }

            return view("kasir/transaksi/acc1", [
                "data" => $trx,
                "carts" => session()->get("cart", []),
                "mekanik" => User::where("role", "mekanik")->get()
            ]);
        }
    }

    public function bayar($id_transaksi)
    {

        return view('kasir.bayar', [
            'transaksi' => Transaction::find($id_transaksi),
        ]);
    }

    public function store_nota(Request $request, $id_transaksi)
    {
        $request->validate([
            'jmlBayar' => ['required'],
        ]);

        $transaksi = Transaction::find($id_transaksi);
        if ($request->jmlBayar < $transaksi->total_purchased) {
            return redirect()->back()->with("gagal", "Periksa Kembali Jumlah Uang Yang Dimasukan");
        } else {
            Transaction::find($id_transaksi)->update([
                'kasir_id' => Auth::user()->id,
                "status" => "paid",
                "role" => "kasir",
            ]);

            $nota = Nota::create([
                "transaction_id" => $id_transaksi,
                "total_payment" => $transaksi->total_purchased,
                "payment_amount" => $request->jmlBayar,
                "change_money" => $request->jmlBayar - $transaksi->total_purchased,
            ]);
            return redirect()->to(route("kasir.cetak.nota", ["id_nota" => $nota->id]))->with("sukses", "Pembayaran Berhasil Dilakukan");
        }
    }

    public function riwayat()
    {
        @$chief_id = Auth::user()->employe->chief_id;

        return view('kasir.index', [
            'mode' => "riwayat",
            'transaksis' => Transaction::where([
                ['chief_id', "=", $chief_id],
                ['status', '=', 'paid']
            ])->get(),
        ]);
    }

    public function cetak_struk($id_nota)
    {
        return view('kasir.nota', [
            'nota' => Nota::find($id_nota),
        ]);
    }

    public function newTransaksi()
    {
        @$chief = Auth::user()->employe->chief_id;
        return view('kasir.newtransaksi', [
            "customer" => Customer::where('chief_id', $chief)->get(),
            "carts" => session()->get("cart", []),
            "product" => MasterProduk::where('chief_id', $chief)->get(),
        ]);
    }
}
