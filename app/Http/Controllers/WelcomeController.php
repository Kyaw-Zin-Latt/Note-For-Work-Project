<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function test()
    {
        $img = "https://media.istockphoto.com/id/1341057712/photo/labyrinth-maze-neon-lighting.webp?s=612x612&w=is&k=20&c=8OAEan3NSs9zbOYFkG5MUNgc9ErDPS4ma8gpG47Z3mI=";
        $value = deeplinkGenerate("Min Ga Lar Parasdfsdf", "San Kyi Tar Pars", $img);
        return $value;
    }
}
