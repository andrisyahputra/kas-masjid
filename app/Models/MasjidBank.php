<?php

namespace App\Models;

use App\Traits\HasMasjid;
use App\Traits\GenerateSlug;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasjidBank extends Model
{
    use HasFactory;
    use HasCreatedBy, HasMasjid;

    protected $guarded = [];
}
