<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Infak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreInfakRequest;
use App\Http\Requests\UpdateInfakRequest;

class InfakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Infak::userMasjid();
        if ($request->filled('q')) {
            $query = $query->where('atas_nama', 'LIKE', '%' . $request->q . '%')
                ->orWhere('sumber', 'LIKE', '%' . $request->q . '%');
        }
        if ($request->filled('tanggal_mulai')) {
            $query = $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query = $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $model = $query->latest()->paginate(50);
        if ($request->page == 'laporan') {
            //return view('kas_laporan', compact('model', 'saldoAkhir', 'pemasukkan', 'pengeluaran'));
        }
        return view('infak_index', compact('model'));
    }

    private function sumberDana()
    {
        // --table->string('sumber')->comment('sumber infak, infak, perorang, instansi, kotak-amal, kotak-jumat');
        return [
            'kotak-amal' => 'Kotak Amal',
            'kotak-jumat' => 'Kotak Jumat',
            'perorang' => 'Per Orang',
            'instansi' => 'Instansi',
            'lain-lain' => 'Lainya',
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['model'] = new Infak;
        $data['title'] = 'Infak Masjid';
        $data['route'] = 'infak.store';
        $data['method'] = 'POST';
        $data['sumberList'] = $this->sumberDana();
        return view('infak_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInfakRequest $request)
    {
        $requestData = $request->validated();
        $requestData['atas_nama'] = $requestData['atas_nama'] ?? 'Hamba Allah';
        try {
            DB::beginTransaction();
            $infak = Infak::create($requestData);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            flash('Data Infak Gagal Disimpan, Error ' . $th->getMessage())->error();
            return back();
        }
        flash('Data Berhasil Disimpan Data infak dan Tersimpan di kas masjid')->success();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Infak $infak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Infak $infak)
    {
        $data['model'] = $infak;
        $data['title'] = 'Edit Infak Masjid';
        $data['route'] = ['infak.update', $infak->id];
        $data['method'] = 'PUT';
        $data['sumberList'] = $this->sumberDana();
        return view('infak_form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInfakRequest $request, Infak $infak)
    {
        $requestData = $request->validated();
        try {
            DB::beginTransaction();
            $infak->update($requestData);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            flash('Data Gagal Diupdate Data infak dan Tidak Tersimpan di kas masjid')->error();
            return back();
        }
        flash('Data Berhasil Diupdate Data infak dan Tersimpan di kas masjid');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infak $infak)
    {
        try {
            //code...
            DB::beginTransaction();
            $infak->delete();
            DB::commit();
        } catch (\Throwable $th) {
            flash('Data Gagal Dihapus Data infak dan Tidak Tersimpan di kas masjid')->error();
            return back();
        }
        flash('Infak Berhasil Dihapus');
        return back();
    }
}
