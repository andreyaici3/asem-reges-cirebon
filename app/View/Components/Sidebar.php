<?php

namespace App\View\Components;

use App\Models\Branch;
use App\Models\ChiefBranch;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Sidebar extends Component
{

    public $menuActive;
    public $menuOpen;
    public function __construct($menuActive = "", $menuOpen = "")
    {
        $this->menuActive = $menuActive;
        $this->menuOpen = $menuOpen;
    }
    
    public function render()
    {
        $cekKepalaToko = ChiefBranch::where("users_id", Auth::user()->id)->first();
        return view('components.sidebar', [
            "kepala" => $cekKepalaToko
        ]);
    }
}
