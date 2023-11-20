<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $data['masjids'] = Masjid::latest()->get();
        return view('welcome_index', $data);
    }
}
