<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MasterProduk;
use App\Models\Nota;
use App\Models\Transaction;
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
                ['chief_id', "=" ,$chief_id],
                ['status', '=', 'unpaid']
            ])->get(),
        ]);
    }

    public function bayar($id_transaksi)
    {

        return view('kasir.bayar', [
            'transaksi' => Transaction::find($id_transaksi),
        ]);
    }

    public function store_nota(Request $request, $id_transaksi){
        $request->validate([
            'jmlBayar' => ['required'],
        ]);

        $transaksi = Transaction::find($id_transaksi);
        if ($request->jmlBayar < $transaksi->total_purchased ){
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

    public function riwayat(){
        @$chief_id = Auth::user()->employe->chief_id;
        
        return view('kasir.index', [
            'mode' => "riwayat",
            'transaksis' => Transaction::where([
                ['chief_id', "=" ,$chief_id],
                ['status', '=', 'paid']
            ])->get(),
        ]);
    }

    public function cetak_struk($id_nota){        
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
