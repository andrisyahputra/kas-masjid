<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use App\Models\Profil;
use Illuminate\Http\Request;

class DataMasjidController extends Controller
{
    public function show($slug)
    {
        $data['model'] = Masjid::where('slug', $slug)->first();
        if (!$data['model']) {
            flash('Data Masjid Tidak Ditemukan')->error();
            return redirect('/');
        }
        $data['kas'] = $data['model']->kas->sortDesc();
        return view('datamasjid_show', $data);
    }

    public function profil($slugMasjid, $slugProfil)
    {
        // echo "$slugMasjid , $slugProfil";
        $data['masjid'] = Masjid::where('slug', $slugMasjid)->firstOrFail();
        $data['profil'] = $data['masjid']->profils()->where('slug', $slugProfil)->firstOrFail();
        return view('datamasjid_profil', $data);
    }
    public function informasi($slugMasjid, $slugInformasi)
    {
        // echo "$slugMasjid , $slugProfil";
        $data['masjid'] = Masjid::where('slug', $slugMasjid)->firstOrFail();
        $data['profil'] = $data['masjid']->informasis()->where('slug', $slugInformasi)->firstOrFail();
        return view('datamasjid_profil', $data);
    }
}
