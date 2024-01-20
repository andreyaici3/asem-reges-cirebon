<?php

namespace Database\Seeders;

use App\Models\AvailableProduct;
use App\Models\Branch;
use App\Models\CarMerk;
use App\Models\CarType;
use App\Models\ChiefBranch;
use App\Models\Customer;
use App\Models\Employe;
use App\Models\MasterProduk;
use App\Models\Nota;
use App\Models\ProductMerk;
use App\Models\ProductType;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class BranchSeeders extends Seeder
{
    public function run()
    {
        collect([
            [
                "name" => "Cabang Kuningan",
                "address" => "Kuningan, Jabar",
                "phone" => 6289675677955,
            ]
        ])->each(function ($branch) {
            Branch::create($branch);
        });


        //tambah kepala toko
        collect([
            [
                "users_id" => 4,
                "branch_id" => 1
            ]
        ])->each(function ($chief) {
            ChiefBranch::create($chief);
        });

        //tambah karyawan
        collect([
            [
                "chief_id" => 1,
                "users_id" => 5,
            ],
            [
                "chief_id" => 1,
                "users_id" => 6,
            ],
            [
                "chief_id" => 1,
                "users_id" => 7
            ],
        ])->each(function($employe){
            Employe::create($employe);
        });

        //tambah vendor
        collect([
            [
                "chief_id" => 1,
                "name" => "Astra Honda Motor",
                "address" => "Jl. Laksda Yos Sudarso - Sunter 1 Jakarta 14350, Indonesia",
                "phone" => "8119500989"
            ]
        ])->each(function($vendor){
            Vendor::create($vendor);
        });

        //tambah mobil
        collect([
            [
                "name" => "Toyota",
                "chief_id" => 1,
            ],
            [
                "name" => "Daihatsu",
                "chief_id" => 1,
            ],
            [
                "name" => "Honda",
                "chief_id" => 1,
            ],
        ])->each(function($merkMobil){
            CarMerk::create($merkMobil);
        });

        collect([
            [
                "merk_id" => 1,
                "name" => "Rush"
            ],
            [
                "merk_id" => 1,
                "name" => "Yaris"
            ],
            [
                "merk_id" => 2,
                "name" => "Terios"
            ],
            [
                "merk_id" => 2,
                "name" => "Ayla"
            ],
            [
                "merk_id" => 2,
                "name" => "Grandmax"
            ],
            [
                "merk_id" => 3,
                "name" => "Jazz",
            ],
            [
                "merk_id" => 3,
                "name" => "Brio",
            ],
            [
                "merk_id" => 3,
                "name" => "Civic",
            ],
            [
                "merk_id" => 3,
                "name" => "CRV",
            ],

        ])->each(function($typeMobil){
            CarType::create($typeMobil);
        });

        //tambah merk produk
        collect([
            [
                "chief_id" => 1,
                "name" => "Bridgestone"
            ],
            [
                "chief_id" => 1,
                "name" => "Kayaba Ultra"
            ],
        ])->each(function($produkMerk){
            ProductMerk::create($produkMerk);
        });

        //tambah type produk
        collect([
            [
                "product_merk_id" => 1,
                "name" => "POTENZA"
            ],
            [
                "product_merk_id" => 1,
                "name" => "TURANZA"
            ],
            [
                "product_merk_id" => 2,
                "name" => "EXCEL-G"
            ],
            [
                "product_merk_id" => 2,
                "name" => "ULTRA SR"
            ],
        ])->each(function($typeProduk){
            ProductType::create($typeProduk);
        });

        //tambahkan master product
        collect([
            [
                "chief_id" => 1,
                "product_type_id" => 2,
                "vendor_id" => 1,
                "code" => "1307109000717",
                "name" => "TURANZA T005A",
                "price" => "10000",
                "selling" => "20000",
                "stok" => "10"
            ],
            [
                "chief_id" => 1,
                "product_type_id" => 2,
                "vendor_id" => "1", 
                "code" => "4423923515928",
                "name" => "POTENZA RE003",
                "price" => "15000",
                "selling" => "25000",
                "stok" => 8
            ],
        ])->each(function($masterProduk){
            MasterProduk::create($masterProduk);
        });

        //tambahkan available product
        collect([
            [
                "product_master_code" => "1307109000717",
                "car_type_id" => 1
            ],
            [
                "product_master_code" => "1307109000717",
                "car_type_id" => 3,
            ],
            [
                "product_master_code" => "4423923515928",
                "car_type_id" => 6
            ],
            [
                "product_master_code" => "4423923515928",
                "car_type_id" => 7,
            ],
            [
                "product_master_code" => "4423923515928",
                "car_type_id" => 8,
            ],
        ])->each(function($available){
            AvailableProduct::create($available);
        });

        //tambahkan customer
        collect([
            [
                "chief_id" => 1,
                "car_type_id" => 1,
                "name" => "Andrey Andriansyah",
                "number_plat" => "E 1838 YP"
            ]
        ])->each(function($customer){
            Customer::create($customer);
        });

        //tambahkan transaksi
        collect([
            [
                "customer_id" => 1,
                "chief_id" => 1,
                "description" => "Ban Sering Bocor, Harus Ganti",
                "total_price" => "40000",
                "total_selling" => "80000",
                "price_service" => "20000",
                "total_purchased" => "100000",
                "total_item" => 4,
                "role" => "kasir",
                "mekanik_id" => 6,
                "kasir_id" => 5,
                "status" => "paid"
            ]
        ])->each(function($transaksi){
            Transaction::create($transaksi);
        });

        //tambahkan transaksi detail
        collect([
            [
                "transaction_id" => 1,
                "product_master_code" => "1307109000717",
                "price" => "10000",
                "selling" => "20000",
                "qty" => 4
            ]
        ])->each(function($transaksiDetail){
            TransactionDetail::create($transaksiDetail);
        });

        //masukan ke nota
        collect([
            [
                "transaction_id" => 1,
                "total_payment" => "100000",
                "payment_amount" => "100000",
                "change_money" => "0",
            ]
        ])->each(function($nota){
            Nota::create($nota);
        });
    }
}
