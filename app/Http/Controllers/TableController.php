<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index() {

        $data = [];
        return view('pages.dashboard.tableview', ['data' => $data, 'active_link' => 'dashboard']);
    }
}
