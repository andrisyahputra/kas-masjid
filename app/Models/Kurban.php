<?php

namespace App\Models;

use App\Traits\HasMasjid;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kurban extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjid;
    // use ConvertContentImageBase64ToUrl;

    protected $guarded = [];
    protected $casts = [
        "tanggal_akhir_pendaftaran" => "date",
    ];

    /**
     * Get all of the comments for the Kurban
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kurbanHewan(): HasMany
    {
        return $this->hasMany(KurbanHewan::class);
    }
    /**
     * Get all of the kurbanPeserta for the Kurban
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kurbanPeserta(): HasMany
    {
        return $this->hasMany(KurbanPeserta::class);
    }
}
