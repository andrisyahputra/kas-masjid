<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use App\Traits\HasMasjid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjid;
    // protected $table = "kas";
    protected $fillable = [
        'masjid_id', 'tanggal', 'kategori', 'keterangan', 'jenis', 'jumlah', 'saldo_akhir', 'created_by'
    ];
    // protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'datetime:d-m-Y'
    ];

    // public function masjid()
    // {
    //     return $this->belongsTo(Masjid::class);
    // }

    // public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }

    public function scopeSaldoAkhir($query, $masjidId = null)
    {
        // $masjidId = $masjidId ?? auth()->user()->masjid_id;
        // return $query = $query->where('masjid_id', $masjidId)
        //     ->orderBy('created_at', 'desc')
        //     ->value('saldo_akhir') ?? 0;
        $masjidId = $masjidId ?? auth()->user()->masjid_id;
        $masjid = Masjid::where('id', $masjidId)->first();
        return $masjid->saldo_akhir ?? 0;
    }

    // public function scopeUserMasjid($q)
    // {
    //     return $q->where('masjid_id', auth()->user()->masjid_id);
    // }
    protected static function booted(): void
    {
        static::creating(function (Kas $kas) {
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
        });

        static::deleting(function (Kas $kas) {

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
        });

        static::updating(function (Kas $kas) {
            // @dd($saldoAkhir);

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
        });
    }
}
