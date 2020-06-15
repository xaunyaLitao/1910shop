<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function hello()
    {
        echo __METHOD__;echo '</br>';
        echo date('Y-m-d h:i:s');
    }
}
