<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MasterProduk;
use App\Models\Nota;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{


    //create transaksi estimasi
    public function create_estimasi(Request $request, $customer)
    {
        //untuk non barang / hanya hasa
        $produks = session()->get('cart', []);
        if ($produks == []) {
            $data = [
                "customer_id" => $customer == 0 ? null : $customer,
                "chief_id" => Auth::user()->employe->chief_id,
                "description" => $request->deskripsi,
                "total_selling" => 0,
                "total_price" => 0,
                "price_service" => $request->price_service,
                "total_purchased" => 0,
                "total_item" => 0,
                "role" => Auth::user()->role,
                "mekanik_id" => null,
                "estimasi_pengerjaan" => $request->estimasi_pengerjaan,
                "kasir_id" => Auth::user()->id,
                "status" => "estimate"
            ];
            Transaction::create($data);
            return redirect()->to(route("dashboard"))->with("sukses", "Transaksi Berhasil Ditambahkan");
        } else {
            $totalHargaBeli = 0;
            $totalHargaJual = 0;
            $totalItem = 0;
            //Tambahkan Transakksi
            $transaksi = Transaction::create([
                "customer_id" => $customer == 0 ? null : $customer,
                'description' => $request->deskripsi,
                'price_service' => $request->price_service,
                "role" => Auth::user()->role,
                "kasir_id" => Auth::user()->id,
                'status' => "estimate",
                "total_purchased" => 0,
                "total_item" => 0,
                "mekanik_id" => null,
                "chief_id" => Auth::user()->employe->chief_id,
                "estimasi_pengerjaan" => $request->estimasi_pengerjaan,
            ]);
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

            foreach ($produks as $produk) {
                unset($produks[$produk['code']]);
                session()->put('cart', $produks);
            }

            Transaction::find($transaksi->id)->update([
                "total_price" => $totalHargaBeli,
                "total_selling" => $totalHargaJual,
                "total_purchased" => $totalHargaJual + $request->price_service,
                "status" => "estimate",
                "total_item" => $totalItem,
            ]);

            return redirect()->to(route("dashboard"))->with("sukses", "Transaksi Berhasil Ditambahkan");
        }
    }

    public function transaksiByPelanggan($id_pelanggan)
    {
        @$chief = Auth::user()->employe->chief_id;
        if (Auth::user()->role == "mekanik") {
            $transaksi = Transaction::where([
                ['customer_id', '=', $id_pelanggan],
                ['chief_id', '=', $chief],
                ['mekanik_id', '=', Auth::user()->id],
            ])->get();
        } else {
            $transaksi = Transaction::where([
                ['customer_id', '=', $id_pelanggan],
                ['chief_id', '=', $chief],
            ])->get();
        }
        return view("mekanik.transaksi.bypelanggan", [
            "customer" =>  Customer::find($id_pelanggan),
            "transaksis" => $transaksi,
            "nomor" => 1,
        ]);
    }

    public function transaksiByPelangganCreate($id_pelanggan)
    {
        @$chief = Auth::user()->employe->chief_id;
        return view("mekanik.transaksi.bypelanggancreate", [
            "customer" =>  Customer::find($id_pelanggan),
            "product" => MasterProduk::where('chief_id', $chief)->get(),
            "carts" => session()->get("cart", []),
            "pelanggan" => $id_pelanggan,
        ]);
    }

    public function searchProduk(Request $request, $id_pelanggan)
    {
        $produk = MasterProduk::where('code', $request->code_barang)->first();

        if ($produk != null) {
            return $this->addproduk($id_pelanggan, $produk->code);
        } else {
            return redirect()->back()->with('gagal', "Produk Tidak ditemukan");
        }
    }

    public function addproduk($id_pelanggan, $code)
    {

        if ($code != "code") {
            $produk = MasterProduk::where("code", $code)->first();
            if ($produk->stok > 0) {
                $cart = session()->get("cart", []);
                if (isset($cart[$code])) {
                    if ($cart[$code]['qty'] < $produk->stok) {
                        $cart[$code]['qty']++;
                        session()->put('cart', $cart);
                        return redirect()->back()->with('sukses', $cart[$code]['name'] . " Berhasil Ditambah");
                    } else {
                        return redirect()->back()->with('gagal', 'Stok Produk ' . $produk->name . " Tidak Tersedia");
                    }
                } else {
                    $cart[$code] = [
                        "code" => $produk->code,
                        "name" => $produk->name,
                        "qty" => 1,
                        "price" => $produk->price,
                        "selling" => $produk->selling,
                    ];
                }
                session()->put('cart', $cart);
                return redirect()->back()->with('sukses', 'Produk Berhasil Ditambahkan');
            } else {
                return redirect()->back()->with('gagal', 'Stok Produk ' . $produk->name . " Tidak Tersedia");
            }
        } else {
            return redirect()->back()->with('gagal', 'Silahkan Pilih Produk');
        }
    }

    public function minProduk($id_pelanggan, $code)
    {
        $cart = session()->get("cart", []);
        if (isset($cart[$code])) {
            $cart[$code]['qty']--;
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('sukses', $cart[$code]['name'] . " Berhasil Dikurangi");
    }

    public function plusProduk($id_pelanggan, $code)
    {
        $produk = MasterProduk::where("code", $code)->first();
        $cart = session()->get("cart", []);
        if (isset($cart[$code])) {
            if ($cart[$code]['qty'] < $produk->stok) {
                $cart[$code]['qty']++;
                session()->put('cart', $cart);
                return redirect()->back()->with('sukses', $cart[$code]['name'] . " Berhasil Ditambah");
            } else {
                return redirect()->back()->with('gagal', 'Stok Produk ' . $produk->name . " Tidak Tersedia Lagi");
            }
        }
    }

    public function trashProduk($id_pelanggan, $code)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$code])) {
            unset($cart[$code]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('sukses', "Produk Berhasil Dihapus");
    }

    public function storeProduk(Request $request, $id_pelanggan)
    {

        $request->validate([
            "price_service" => ['required']
        ]);

        if ($id_pelanggan == 0) {
            $idP = null;
        } else {
            $idP = $id_pelanggan;
        }

        if (isset($request->kasir_mode)) {
            $kasir_id = Auth::user()->id;
            $status = "paid";
            $mekanik_id = null;
            $role = "kasir";
            $status_udpate = "paid";
            $request->validate([
                'jmlBayar' => ['required'],
            ]);
        } else {
            $kasir_id = null;
            $status = "waiting";
            $mekanik_id = Auth::user()->id;
            $role = "mekanik";
            $status_udpate = "unpaid";
        }


        $totalHargaBeli = 0;
        $totalHargaJual = 0;
        $totalItem = 0;
        //Tambahkan Transakksi
        $transaksi = Transaction::create([
            'customer_id' => $idP,
            'description' => $request->deskripsi,
            'price_service' => $request->price_service,
            'role' => $role,
            'kasir_id' => $kasir_id,
            'status' => $status,
            "total_purchased" => 0,
            "total_item" => 0,
            "mekanik_id" => $mekanik_id,
            "chief_id" => Auth::user()->employe->chief_id,
        ]);
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

            if (!isset($request->kasir_mode)) {
                unset($produks[$produk['code']]);
                session()->put('cart', $produks);
            }
        }

        Transaction::find($transaksi->id)->update([
            "total_price" => $totalHargaBeli,
            "total_selling" => $totalHargaJual,
            "total_purchased" => $totalHargaJual + $request->price_service,
            "status" => $status_udpate,
            "total_item" => $totalItem,
        ]);

        $trx = Transaction::find($transaksi->id);

        if (isset($request->kasir_mode)) {

            if ($request->jmlBayar < $trx->total_purchased) {
                Transaction::find($transaksi->id)->delete();
                return redirect()->back()->with("gagal", "Periksa Kembali Jumlah Uang Yang Dimasukan");
            }

            $nota = Nota::create([
                "transaction_id" => $trx->id,
                "total_payment" => $trx->total_purchased,
                "payment_amount" => $request->jmlBayar,
                "change_money" => $request->jmlBayar - $trx->total_purchased,
            ]);

            foreach ($produks as $produk) {
                unset($produks[$produk['code']]);
                session()->put('cart', $produks);
            }

            return redirect()->to(route("kasir.cetak.nota", ["id_nota" => $nota->id]))->with("sukses", "Pembayaran Berhasil Dilakukan");
        } else {
            return redirect()->to(route("mekanik.transaksi.bypelanggan", ['id_pelanggan' => $id_pelanggan]))->with("sukses", "Transaksi Berhasil dan Sudah disetorkan ke kasir untuk pembayaran");
        }
    }

    public function destroyTransaksi($id_pelanggan, $id_transaksi)
    {
        $transaksi = Transaction::find($id_transaksi);

        foreach ($transaksi->detail as $transaksiDetail) {
            $code = $transaksiDetail->product_master_code;
            $produkItem = MasterProduk::where('code', $code)->first();
            $transact = TransactionDetail::where("product_master_code", $code)->first();
            $stokBaru = $produkItem->stok + $transact->qty;
            MasterProduk::where('code', $code)->update([
                "stok" => $stokBaru
            ]);
        }

        $transaksi->delete();

        return redirect()->to(route("mekanik.transaksi.bypelanggan", ['id_pelanggan' => $id_pelanggan]))->with("sukses", "Transaksi Berhasil Dihapus");
    }

    public function detail($id_pelanggan, $id_transaksi)
    {
        return view('mekanik.transaksi.invoice_mekanik', [
            "customer" =>  Customer::find($id_pelanggan),
            "pelanggan" => $id_pelanggan,
            "transaksi" => Transaction::find($id_transaksi),
        ]);
    }
}
