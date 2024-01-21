<?php

use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Gudang\MasterProdukController;
use App\Http\Controllers\Gudang\MerkMobilController;
use App\Http\Controllers\Gudang\MerkProdukController;
use App\Http\Controllers\Gudang\TypeMobilController;
use App\Http\Controllers\Gudang\TypeProdukController;
use App\Http\Controllers\Gudang\VendorController;
use App\Http\Controllers\Kasir\KasirController;
use App\Http\Controllers\Mekanik\CustomerController;
use App\Http\Controllers\Super\MappingKepalaController;
use App\Http\Controllers\Super\MasterAdminController;
use App\Http\Controllers\Super\MasterCabangController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth", "user-role:superuser|superadmin|mekanik|admin|gudang|kasir"])->group(function () {
    Route::get("/", [DashboardController::class, 'index'])->name("dashboard");
});

Route::controller(AuthenticationController::class)->group(function () {
    Route::get("/login", 'login')->name('auth.login');
    Route::get("/change-password", 'changePassword')->name('auth.change');
    Route::put("/change-password", 'storePassword');
    Route::post("/login", "storeLogin");
    Route::post("/logout", "logout")->name("auth.logout");
});

Route::middleware(["auth", "user-role:superuser|superadmin"])->group(function () {
    Route::controller(MasterCabangController::class)->group(function () {
        Route::get("/cabang", "index")->name("super.cabang");
        Route::get("/cabang/create", "create")->name("super.cabang.create");
        Route::get("/cabang/{id}/edit", 'edit')->name("super.cabang.edit");
        Route::put("/cabang/{id}", "update")->name("super.cabang.update");
        Route::delete("/cabang/{id}", "destroy")->name("super.cabang.delete");
        Route::post("/cabang", "store");
        Route::get("/cabang/kepala/{id}/edit", "updateKepala")->name("super.cabang.kepala.edit");
    });
    Route::controller(MasterAdminController::class)->group(function () {
        Route::get("/admin", "index")->name("super.admin");
        Route::get("/admin/create", "create")->name("super.admin.create");
        Route::get("/admin/{id}/edit", 'edit')->name("super.admin.edit");
        Route::put("/admin/{id}", "update")->name("super.admin.update");
        Route::delete("/admin/{id}", "destroy")->name("super.admin.delete");
        Route::post("/admin", "store");
    });
    Route::controller(MappingKepalaController::class)->group(function () {
        Route::get("/kepala", "index")->name("super.kepala");
        Route::get("/kepala/create", "create")->name("super.kepala.create");
        Route::get("/kepala/{id}/edit", 'edit')->name("super.kepala.edit");
        Route::put("/kepala/{id}", "update")->name("super.kepala.update");
        Route::delete("/kepala/{id}", "destroy")->name("super.kepala.delete");
        Route::post("/kepala", "store");
    });
});

Route::middleware(["auth", "user-role:superuser|superadmin|admin"])->group(function () {
    Route::controller(KaryawanController::class)->group(function () {
        Route::get("/karyawan/{type}", 'index')->name("admin.karyawan");
        Route::get("/karyawan/create/{type}", 'create')->name("admin.karyawan.create");
        Route::post("/karyawan/{type}", 'store');
        Route::get("/karyawan/{type}/edit", 'edit')->name("admin.karyawan.edit");
        Route::delete("/kepala/{type}/{id}", "destroy")->name("admin.karyawan.delete");
    });
});

Route::middleware(["auth", "user-role:superuser|superadmin|gudang"])->group(function () {
    Route::controller(VendorController::class)->group(function () {
        Route::get("/vendor", 'index')->name("gudang.vendor");
        Route::get("/vendor/create", 'create')->name("gudang.vendor.create");
        Route::get("/vendor/{id}/edit", 'edit')->name("gudang.vendor.edit");
        Route::put("/vendor/{id}", 'update')->name("gudang.vendor.update");
        Route::delete("/vendor/{id}", 'destroy')->name("gudang.vendor.delete");
        Route::post("/vendor", 'store');
    });

    Route::controller(MerkMobilController::class)->group(function () {
        Route::get("/mobil/merk", "index")->name("gudang.mobil.merk");
        Route::get("/mobil/merk/create", "create")->name("gudang.mobil.merk.create");
        Route::post("/mobil/merk", "store");
        Route::get("/mobil/merk/{id}/edit", "edit")->name("gudang.mobil.merk.edit");
        Route::put("/mobil/merk/{id}", "update")->name("gudang.mobil.merk.update");
        Route::delete("/mobil/merk/{id}", 'destroy')->name("gudang.mobil.merk.delete");
    });

    Route::controller(TypeMobilController::class)->group(function () {
        Route::get("/mobil/{id_merk}/type", "index")->name("gudang.mobil.type");
        Route::get("/mobil/{id_merk}/type/create", "create")->name("gudang.mobil.type.create");
        Route::post("/mobil/{id_merk}/type", "store");
        Route::get("/mobil/type/{id_type}/edit/{id_merk}", "edit")->name("gudang.mobil.type.edit");
        Route::put("/mobil/type/{id_type}/{id_merk}", "update")->name("gudang.mobil.type.update");
        Route::delete("/mobil/type/{id_type}/{id_merk}", 'destroy')->name("gudang.mobil.type.delete");
    });

    Route::controller(MerkProdukController::class)->group(function () {
        Route::get("/product/merk", "index")->name("gudang.produk.merk");
        Route::get("/product/merk/create", "create")->name("gudang.produk.merk.create");
        Route::post("/product/merk", "store");
        Route::get("/product/merk/{id_merk}/edit", "edit")->name("gudang.produk.merk.edit");
        Route::put("/product/merk/{id_merk}", "update")->name("gudang.produk.merk.update");
        Route::delete("/product/merk/{id_merk}", 'destroy')->name("gudang.produk.merk.delete");
    });

    Route::controller(TypeProdukController::class)->group(function () {
        Route::get("/produk/merk/{id_merk}/type", "index")->name("gudang.produk.type");
        Route::get("/produk/merk/{id_merk}/type/create", "create")->name("gudang.produk.type.create");
        Route::post("/produk/merk/{id_merk}/type", "store");
        Route::get("/produk/merk/{id_merk}/type/{id_type}", "edit")->name("gudang.produk.type.edit");
        Route::put("/produk/merk/{id_merk}/type/{id_type}", "update")->name("gudang.produk.type.update");
        Route::delete("/produk/merk/{id_merk}/type/{id_type}", "destroy")->name("gudang.produk.type.delete");
    });

    Route::controller(MasterProdukController::class)->group(function () {
        Route::get("/produk/master", "index")->name("gudang.produk.master");
        Route::get("/produk/master/create", "create")->name("gudang.produk.create");
        Route::post("/produk/master", "store");
        Route::get("/produk/master/{id}/edit", "edit")->name("gudang.produk.master.edit");
        Route::put("/produk/master/{id}", "update")->name("gudang.produk.master.update");
        Route::delete("/produk/master/{id}", "destroy")->name("gudang.produk.master.delete");
    });
});

Route::middleware(["auth", "user-role:superuser|superadmin|mekanik"])->group(function () {
    Route::controller(CustomerController::class)->group(function () {
        Route::get("/pelanggan", "index")->name("mekanik.pelanggan");
        Route::get("/pelanggan/create", "create")->name("mekanik.pelanggan.create");
        Route::post("/pelanggan", "store")->name("mekanik.pelanggan");
        Route::get("/pelanggan/{id}/edit", "edit")->name("mekanik.pelanggan.edit");
        Route::put("/pelanggan/{id}", "update")->name("mekanik.pelanggan.update");
        Route::delete("/pelanggan/{id}", "destroy")->name("mekanik.pelanggan.delete");
    });
});

Route::middleware(["auth", "user-role:superuser|superadmin|kasir|mekanik"])->group(function () {
    Route::controller(TransaksiController::class)->group(function () {
        Route::get("/transaksi/{id_pelanggan}/byPelanggan", 'transaksiByPelanggan')->name("mekanik.transaksi.bypelanggan");
        Route::get("/transaksi/{id_pelanggan}/byPelanggan/create", 'transaksiByPelangganCreate')->name("mekanik.transaksi.bypelanggan.create");
        Route::post("/transaksi/{id_pelanggan}/byPelanggan/addProduk/{code}", 'addproduk')->name("mekanik.transaksi.bypelanggan.add");
        Route::post("/transaksi/{id_pelanggan}/byPelanggan/search", 'searchProduk')->name("mekanik.transaksi.bypelanggan.search");
        Route::put("/transaksi/{id_pelanggan}/byPelanggan/minProduk/{code}", 'minproduk')->name("mekanik.transaksi.bypelanggan.min");
        Route::put("/transaksi/{id_pelanggan}/byPelanggan/plusProduk/{code}", 'plusProduk')->name("mekanik.transaksi.bypelanggan.plus");
        Route::delete("/transaksi/{id_pelanggan}/byPelanggan/trashProduk/{code}", 'trashProduk')->name("mekanik.transaksi.bypelanggan.trash");
        Route::post("/transaksi/{id_pelanggan}/byPelanggan/store", 'storeProduk')->name("mekanik.transaksi.bypelanggan.store");
        Route::delete("/transaksi/{id_pelanggan}/byPelanggan/delete/{id_transaksi}", "destroyTransaksi")->name('mekanik.transaksi.bypelanggan.delete');
        Route::get("/transaksi/{id_pelanggan}/detail/{id_transaksi}", 'detail')->name('mekanik.transaksi.detail');
    });

    Route::controller(KasirController::class)->group(function(){
        Route::get("/cetak/nota/{id_nota}", 'cetak_struk')->name("kasir.cetak.nota");
    });
});

Route::middleware(["auth", "user-role:superuser|superadmin|kasir"])->group(function () {
    Route::controller(KasirController::class)->group(function () {
        Route::get("/bayar", 'index')->name("kasir");
        Route::get("/bayar/{id_transaksi}", "bayar")->name("kasir.bayar");
        Route::put("/bayar/{id_transaksi}/create", "store_nota")->name("kasir.bayar.proses");
        Route::get("/kasir/riwayat", "riwayat")->name("kasir.riwayat");
        Route::get("/kasir/transaksi-new", 'newTransaksi')->name("kasir.transaksi.nonservice");
    });
});

Route::middleware(["auth", "user-role:superuser|superadmin|gudang|kasir"])->group(function () {
    Route::get("/produk/master/{code}/generate", [MasterProdukController::class, 'generate_barcode'])->name("master.produk.generate");
});
