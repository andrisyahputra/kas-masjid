<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ConvertContentImageBase64ToUrl;

class ProfilController extends Controller

{
    use ConvertContentImageBase64ToUrl;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $profils = Profil::userMasjid()->latest()->paginate(50);
        return view('profil_index', compact('profils'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['profil'] = new Profil;
        $data['route'] = 'profil.store';
        $data['method'] = 'POST';
        $data['listKategori'] = [
            'visi-misi' => 'Misi Visi',
            'sejarah' => 'Sejarah',
            'struktur-organisasi' => 'Struktur Organisasi'
        ];
        return view('profil_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // @dd($request->all());
        $requestData = $request->validate([
            'kategori' => 'required',
            'judul' => 'required',
            'konten' => 'required',
        ]);
        $kontenWithUrls = $this->convertBase64ImagesToUrls($requestData['konten']);
        $requestData['konten'] = $kontenWithUrls;
        // $requestData['slug'] = Str::slug($request->judul);
        Profil::create($requestData);
        flash('Data Berhasil Disimpan');
        return back();
    }


    /**
     * Display the specified resource.
     */
    public function show(Profil $profil)
    {
        $data['profil'] = $profil;
        return view('profil_show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profil $profil)
    {
        $data['profil'] = $profil;
        $data['route'] = ['profil.update', $profil->id];
        $data['method'] = 'PUT';
        $data['listKategori'] = [
            'visi-misi' => 'Misi Visi',
            'sejarah' => 'Sejarah',
            'struktur-organisasi' => 'Struktur Organisasi'
        ];
        return view('profil_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profil $profil)
    {
        $requestData = $request->validate([
            'kategori' => 'required',
            'judul' => 'required',
            'konten' => 'required',
        ]);
        $kontenWithUrls = $this->convertBase64ImagesToUrls($requestData['konten']);
        $requestData['konten'] = $kontenWithUrls;
        // $requestData['slug'] = Str::slug($request->judul);
        $profil = Profil::findOrFail($profil->id);
        $profil->update($requestData);
        flash('Data Berhasil Diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profil $profil)
    {
        $profil->delete();
        flash('Data Berhasil Dihapus');
        return back();
    }
}
