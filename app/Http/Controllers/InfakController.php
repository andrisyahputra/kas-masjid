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
        // $table->foreignId('masjid_id');
        //     $table->dateTime('tanggal');
        //     $table->string('kategori')->nullable();
        //     $table->text('keterangan');
        //     $table->enum('jenis', ['masuk', 'keluar']);
        //     $table->bigInteger('jumlah');
        //     $table->bigInteger('saldo_akhir');
        //     $table->foreignId('created_by')->index();
        $requestData = $request->validated();
        DB::beginTransaction();
        $requestData['atas_nama'] = $requestData['atas_nama'] ?? 'Hamba Allah';
        $infak = Infak::create($requestData);
        if ($infak->jenis == 'uang') {
            $kas = new Kas();
            $kas->infak_id = $infak->id;
            $kas->masjid_id = $request->user()->masjid_id;
            $kas->tanggal = $infak->created_at;
            $kas->kategori = 'Infak- ' . $infak->sumber;
            $kas->keterangan = 'Infak- ' . $infak->sumber . ' dari ' . $infak->atas_nama;
            $kas->jenis = 'masuk';
            $kas->jumlah = $infak->jumlah;
            $kas->save();
        }
        DB::commit();
        flash('Data Berhasil Disimpan Data infak dan Tersimpan di kas masjid');
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
        DB::beginTransaction();
        $infak->update($requestData);
        $kas = $infak->kas;
        // dd($kas);
        $kas->jumlah = $infak->jumlah;
        $kas->save();
        DB::commit();
        flash('Data Berhasil Diupdate Data infak dan Tersimpan di kas masjid');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Infak $infak)
    {
        if ($infak->kas != null) {
            $infak->kas->delete();
        }
        // dd($infak->kas);
        $infak->delete();
        flash('Infak Berhasil Dihapus');
        return back();
    }
}
