<?php

namespace App\Observers;

use App\Models\Kas;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class KasObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Kas "created" event.
     */
    public function creating(Kas $kas): bool
    {
        $saldoAwal = Kas::saldoAkhir();
        $saldoAkhir = $saldoAwal;
        // dd($saldoAkhir);

        if ($kas->jenis == 'masuk') {
            $saldoAkhir += $kas->jumlah;
        } else {
            $saldoAkhir -= $kas->jumlah;
        }

        if ($saldoAkhir <= -1) {
            Flash('Data Kas gagal DiKeluarkan <b>' . format_rupiah($kas->jumlah, true) . '</b>. Saldo Akhir tidak boleh kurang dari 0. saldo terakhir sisa <b>' . format_rupiah($saldoAwal, true) . '</b>')->error();
            return false;
        }
        $kas->masjid->update(['saldo_akhir' => $saldoAkhir]);
        return true;
    }

    /**
     * Handle the Kas "updated" event.
     */
    public function updating(Kas $kas): bool
    {
        $saldoAwal = Kas::saldoAkhir();
        $saldoAkhir = $saldoAwal;

        if (
            $kas->jenis == 'masuk'
        ) {
            $saldoAkhir -= $kas->getOriginal('jumlah');
            $saldoAkhir += $kas->jumlah;
        }

        if ($kas->jenis == 'keluar') {

            $saldoAkhir += $kas->getOriginal('jumlah');
            $saldoAkhir -= $kas->jumlah;
            if ($saldoAkhir <= -1) {
                Flash('Data Kas gagal DiKeluarkan <b>' . format_rupiah($kas->jumlah, true) . '</b>. Saldo Akhir tidak boleh kurang dari 0. saldo terakhir sisa <b>' . format_rupiah($saldoAwal, true) . '</b>')->error();
                return false;
            }
        }
        auth()->user()->masjid->update(['saldo_akhir' => $saldoAkhir]);
        return true;
    }



    /**
     * Handle the Kas "deleted" event.
     */
    public function deleting(Kas $kas): bool
    {
        $saldoAwal = Kas::saldoAkhir();
        $saldoAkhir = $saldoAwal;
        if ($kas->jenis == 'masuk') {
            $saldoAkhir -= $kas->jumlah;
        }
        if ($kas->jenis == 'keluar') {
            $saldoAkhir += $kas->jumlah;
        }

        if ($saldoAkhir <= -1) {
            Flash('Data Kas ' . format_rupiah($kas->jumlah) . ' gagal dihapus. Saldo Akhir tidak boleh kurang dari 0 adalah <b> ' .  format_rupiah($saldoAwal, true) . '</b>')->error();
            return false;
        }

        $kas->masjid->update(['saldo_akhir' => $saldoAkhir]);
        return true;
    }

    /**
     * Handle the Kas "restored" event.
     */
    public function restored(Kas $kas): void
    {
        //
    }

    /**
     * Handle the Kas "force deleted" event.
     */
    public function forceDeleted(Kas $kas): void
    {
        //
    }
}
