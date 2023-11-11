<?php

namespace App\Models;

use App\Traits\HasMasjid;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
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
}
