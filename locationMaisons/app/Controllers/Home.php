<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }

    public function createAccount(): string
    {
        return view('create_account');
    }

    public function login(): string
    {
        return view('login');
    }
}
