<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Informasi;
use Illuminate\Http\Request;
use App\Models\Profil;
use App\Traits\ConvertContentImageBase64ToUrl;

class InformasiController extends Controller
{
    use ConvertContentImageBase64ToUrl;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Informasi::userMasjid()->latest()->paginate(50);
        $title = "Informasi Masjid";
        return view('informasi_index', compact('models', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['model'] = new Informasi;
        $data['title'] = 'Tambah Informasi Baru Masjis';
        $data['route'] = 'informasi.store';
        $data['method'] = 'POST';
        $data['kategoris'] = Kategori::pluck('nama', 'id');
        return view('informasi_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'kategori' => 'required',
            'judul' => 'required',
            'konten' => 'nullable',
        ]);
        $kontenWithUrls = $this->convertBase64ImagesToUrls($requestData['konten']);
        $requestData['konten'] = $kontenWithUrls;
        // $requestData['slug'] = Str::slug($request->judul);
        Informasi::create($requestData);
        flash('Data Berhasil Disimpan');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Informasi $informasi)
    {
        $data['model'] = $informasi;
        $data['title'] = 'Detail Informasi Masjid';
        return view('informasi_show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Informasi $informasi)
    {
        $data['model'] = $informasi;
        $data['title'] = 'Edit Informasi Masjid';
        $data['route'] = ['informasi.update', $informasi->id];
        $data['method'] = 'PUT';
        $data['kategoris'] = Kategori::pluck('nama', 'id');
        return view('informasi_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informasi $informasi)
    {
        $requestData = $request->validate([
            'kategori' => 'required',
            'judul' => 'required',
            'konten' => 'nullable',
        ]);
        $kontenWithUrls = $this->convertBase64ImagesToUrls($requestData['konten']);
        $requestData['konten'] = $kontenWithUrls;
        $model = Informasi::findOrFail($informasi->id);
        $model->update($requestData);
        flash('Data Berhasil Diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informasi $informasi)
    {
        $informasi->delete();
        flash('Data Berhasil Dihapus');
        return back();
    }
}
