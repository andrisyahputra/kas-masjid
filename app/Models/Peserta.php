<?php

namespace App\Models;

use App\Traits\HasMasjid;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peserta extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjid;
    // use ConvertContentImageBase64ToUrl;

    protected $guarded = [];
}
