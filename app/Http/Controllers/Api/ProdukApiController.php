<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MasterProduk;
use Illuminate\Http\Request;

class ProdukApiController extends Controller
{
    public function getProduk($code)
    {
        return MasterProduk::with('available', 'tipe_produk', 'vendor')->where('code', $code)->first();
    }
}
