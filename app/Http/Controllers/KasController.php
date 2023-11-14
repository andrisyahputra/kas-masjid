<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Http\Requests\StoreKasRequest;
use App\Http\Requests\UpdateKasRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class KasController extends Controller
{
    // ...
    public function index(Request $request)
    {
        $query = Kas::userMasjid();
        if ($request->filled('q')) {
            $query = $query->where('keterangan', 'LIKE', '%' . $request->q . '%');
        }
        if ($request->filled('tanggal_mulai')) {
            $query = $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query = $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $kasList = $query->latest()->paginate(50);
        $saldoAkhir = Kas::saldoAkhir();
        $pemasukkan = $kasList->where('jenis', 'masuk')->sum('jumlah');
        $pengeluaran = $kasList->where('jenis', 'keluar')->sum('jumlah');
        if (request('page') == 'laporan') {
            return view('kas_laporan', compact('kasList', 'saldoAkhir', 'pemasukkan', 'pengeluaran'));
        }
        return view('kas_index', compact('kasList', 'saldoAkhir', 'pemasukkan', 'pengeluaran'));
    }

    public function create()
    {
        $kas = new Kas;
        $saldoAkhir = Kas::saldoAkhir();
        $disable = [];
        return view('kas_form', compact('kas', 'saldoAkhir', 'disable'));
    }



    public function store(Request $request)
    {

        $requestData = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable',
            'keterangan' => 'required',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required',
        ]);

        $tanggalTransaksi = Carbon::parse($requestData['tanggal']);
        $tglTransaksi = $tanggalTransaksi->format('d-m-Y');
        $tglSekarang = Carbon::now()->format('d-m-Y');
        if ($tglTransaksi != $tglSekarang) {
            Flash('Data Kas gagal Ditambahkan. Tranksaski tidak bisa ditambah tanggal <b>' . $tglTransaksi . '</b>. Sebelum tanggal Sekarang <b>' . $tglSekarang . '</b>')->error();
            return back();
        }

        $requestData['jumlah'] = str_replace('.', '', $requestData['jumlah']);

        $saldoAwal = Kas::saldoAkhir();
        $saldoAkhir = $saldoAwal;
        // @dd($saldoAkhir);

        if ($requestData['jenis'] == 'masuk') {
            $saldoAkhir += $requestData['jumlah'];
        } else {
            $saldoAkhir -= $requestData['jumlah'];
        }


        if ($saldoAkhir <= -1) {
            Flash('Data Kas gagal DiKeluarkan <b>' . format_rupiah($requestData['jumlah'], true) . '</b>. Saldo Akhir tidak boleh kurang dari 0. saldo terakhir sisa <b>' . format_rupiah($saldoAwal, true) . '</b>')->error();
            return back();
        }

        // @dd($saldoAkhir);


        $kas = new Kas();
        $kas->fill($requestData);
        // @dd($kas);
        // $kas->masjid_id = auth()->user()->masjid_id;
        // $kas->created_by = auth()->user()->id;
        // $kas->saldo_akhir = $saldoAkhir;
        $kas->save();
        auth()->user()->masjid->update(['saldo_akhir' => $saldoAkhir]);
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil Di Tambah');
    }
    public function edit(Kas $ka)
    {
        // dd($ka);
        // $kas = Kas::userMasjid()->findOrFail($id);
        $kas = $ka;
        $saldoAkhir = Kas::saldoAkhir();
        $disable = ['disabled' => 'disabled'];
        return view('kas_form', compact('kas', 'saldoAkhir', 'disable'));
    }

    public function update(Request $request, Kas $ka)
    {
        $validatedData = $request->validate([
            'kategori' => 'nullable',
            'keterangan' => 'required',
            'jumlah' => 'required'
        ]);

        $jumlah = str_replace('.', '', $validatedData['jumlah']);
        $saldoAkhir = Kas::saldoAkhir();


        $kas = $ka;


        if ($kas->jenis == 'masuk') {
            $sisa =  $jumlah - $kas->jumlah;
            $saldoAkhir += $sisa;
            // $saldoAwal = Kas::saldoAkhir() + $jumlah;
            // @dd($jumlah);
        }

        if ($kas->jenis == 'keluar') {
            $sisa =  $jumlah - $kas->jumlah;
            // $saldoAwal = $saldoAkhir + $jumlah; //sisa awal sebelum di keluarkan
            $saldoAkhir -= $sisa;
            // @dd($saldoAwal);
            // @dd($saldoAkhir);
        }

        if ($saldoAkhir <= -1) {
            Flash('Data Kas gagal DiKeluarkan <b>' . format_rupiah($jumlah, true) . '</b>. Saldo Akhir tidak boleh kurang dari 0 <b>' . format_rupiah($saldoAkhir, true) . '</b>')->error();
            return back();
        }
        // $saldoAkhir = $saldoAkhir + $jumlah;
        $validatedData['jumlah'] = $jumlah;
        $kas->fill($validatedData);
        $kas->save();
        auth()->user()->masjid->update(['saldo_akhir' => $saldoAkhir]);
        return redirect()->route('kas.index')->with('success', 'Data kas Berhasil Di Update');
    }

    public function destroy(Kas $ka)
    {
        $kas = $ka;

        if ($kas->infak_id != null) {
            Flash('Data Kas Gagal dihapus, Data ini terhubung data infak, Silakan hapus di data infak')->error();
            return back();
        }


        $saldoAkhir = Kas::saldoAkhir();
        if ($kas->jenis == 'masuk') {
            $saldoAkhir -= $kas->jumlah;
        }
        if ($kas->jenis == 'keluar') {
            $saldoAkhir += $kas->jumlah;
        }

        if ($saldoAkhir <= -1) {
            Flash('Data Kas gagal dihapus. Saldo Akhir tidak boleh kurang dari 0 adalah <b> ' .  format_rupiah($saldoAkhir, true) . '</b>')->error();
            return back();
        }
        // $kasBaru->saldo_akhir = $saldoAkhir;
        $kas->delete();
        auth()->user()->masjid->update(['saldo_akhir' => $saldoAkhir]);
        // $this->hitungSaldoAkhir(); // Panggil method hitungSaldoAkhir setelah menghapus data
        return redirect()->route('kas.index')->with('success', 'Data KAS Berhasil disimpan');
    }
}
