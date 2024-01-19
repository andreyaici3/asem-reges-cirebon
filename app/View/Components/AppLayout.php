<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
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
        return view('layouts.app-layout');
    }
}
