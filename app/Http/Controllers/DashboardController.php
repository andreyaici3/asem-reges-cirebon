<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Kasir\KasirController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');
        switch ($role){
            case "kasir":
                $kasir = new KasirController();
                return $kasir->index();
                break;
            default:
                return view('dashboard.index');
                break;
        }
    }
}
