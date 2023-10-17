<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {

        $data = [
            "name" => "ne znam"
        ];

        return view('admin.users.index', $data);
    }
}
