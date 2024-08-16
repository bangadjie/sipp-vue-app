<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Admin_pdoController extends Controller
{
    public function index() {
        return view('Home_Admin_pdo');
    }
}
