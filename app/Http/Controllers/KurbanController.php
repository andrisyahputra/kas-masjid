<?php

namespace App\Http\Controllers;

use App\Models\Kurban;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKurbanRequest;
use App\Http\Requests\UpdateKurbanRequest;
use App\Traits\ConvertContentImageBase64ToUrl;

class KurbanController extends Controller
{
    use ConvertContentImageBase64ToUrl;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Kurban::userMasjid()->latest()->paginate(50);
        $title = "Data Kurban Masjid";
        return view('kurban_index', compact('models', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['model'] = new Kurban;
        $data['title'] = 'Tambah Data Kurban Masjid';
        $data['route'] = 'kurban.store';
        $data['method'] = 'POST';
        return view('kurban_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'tahun_hijriah' => 'required',
            'tahun_masehi' => 'required',
            'tanggal_akhir_pendaftaran' => 'required',
            'konten' => 'nullable',
        ]);
        $kontenWithUrls = $this->convertBase64ImagesToUrls($requestData['konten']);
        $requestData['konten'] = $kontenWithUrls;
        // $requestData['slug'] = Str::slug($request->judul);
        Kurban::create($requestData);
        flash('Data Berhasil Disimpan');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Kurban $kurban)
    {
        // $data['model'] = $informasi;
        // $data['title'] = 'Detail Informasi Masjid';
        // return view('informasi_show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kurban $kurban)
    {
        $data['model'] = $kurban;
        $data['title'] = 'Edit Data Kurban Masjid';
        $data['route'] = ['kurban.update', $kurban->id];
        $data['method'] = 'PUT';
        return view('kurban_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kurban $kurban)
    {
        $requestData = $request->validate([
            'tahun_hijriah' => 'required',
            'tahun_masehi' => 'required',
            'tanggal_akhir_pendaftaran' => 'required',
            'konten' => 'nullable',
        ]);
        $kontenWithUrls = $this->convertBase64ImagesToUrls($requestData['konten']);
        $requestData['konten'] = $kontenWithUrls;
        $kurban->update($requestData);
        flash('Data Berhasil Diubah');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kurban $kurban)
    {
        $kurban->delete();
        flash('Data Berhasil Dihapus');
        return back();
    }
}
