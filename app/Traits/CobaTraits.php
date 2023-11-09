<?php

namespace App\Traits;

trait CobaTraits
{
    public function cobaTrits($namaDepan, $namBelakang)
    {
        // $image = null;
        $fulname = $namaDepan . ' ' .  $namBelakang;
        return $fulname;
    }
}
