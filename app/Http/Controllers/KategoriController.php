<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Traits\ConvertContentImageBase64ToUrl;


class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Kategori::userMasjid()->latest()->paginate(50);
        $title = "Kategori Informasi";
        return view('kategori_index', compact('models', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['model'] = new Kategori;
        $data['title'] = 'Tambah Kategori Masjis';
        $data['route'] = 'kategori.store';
        $data['method'] = 'POST';
        return view('kategori_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */

    use ConvertContentImageBase64ToUrl;
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'nama' => 'required',
            'keterangan' => 'nullable',
        ]);
        $kontenWithUrls = $this->convertBase64ImagesToUrls($requestData['keterangan']);
        $requestData['keterangan'] = $kontenWithUrls;
        // $requestData['slug'] = Str::slug($request->judul);
        Kategori::create($requestData);
        flash('Data Berhasil Disimpan');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        $data['model'] = $kategori;
        $data['title'] = 'Edit kategori Masjid';
        $data['route'] = ['kategori.update', $kategori->id];
        $data['method'] = 'PUT';
        return view('kategori_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $requestData = $request->validate([
            'nama' => 'required',
            'keterangan' => 'nullable',
        ]);
        $kontenWithUrls = $this->convertBase64ImagesToUrls($requestData['keterangan']);
        $requestData['keterangan'] = $kontenWithUrls;
        $kategori->update($requestData);
        flash('Data Berhasil Diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        flash('Data Berhasil Dihapus');
        return back();
    }
}
