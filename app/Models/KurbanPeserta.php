<?php

namespace App\Models;

use App\Models\Peserta;
use App\Traits\HasMasjid;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KurbanPeserta extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjid;
    // use ConvertContentImageBase64ToUrl;

    protected $guarded = [];
    /**
     * Get the peserta that owns the KurbanPeserta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class);
    }
    /**
     * Get the kurbanHewan that owns the KurbanPeserta
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kurbanHewan(): BelongsTo
    {
        return $this->belongsTo(KurbanHewan::class);
    }
}
