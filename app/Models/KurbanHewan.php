<?php

namespace App\Models;

use App\Traits\HasMasjid;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KurbanHewan extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjid;
    // use ConvertContentImageBase64ToUrl;

    protected $guarded = [];
    protected $appends = ['nama_full'];

    public function getNamaFullAttribute()
    {
        return ucwords($this->hewan) . " - {$this->kriteria} - " . format_rupiah($this->iuran_perorang);
    }

    /**
     * Get the user that owns the KurbanHewan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kurban(): BelongsTo
    {
        return $this->belongsTo(Kurban::class);
    }
    /**
     * Get all of the kurbanPeserta for the KurbanHewan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kurbanPeserta(): HasMany
    {
        return $this->hasMany(KurbanPeserta::class);
    }
}
