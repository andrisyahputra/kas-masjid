<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ConvertContentImageBase64ToUrl
{
    protected function convertBase64ImagesToUrls($content)
    {
        $pattern = '/<img.*?src=["\'](data:image\/[^;]+;base64,([^\'"]+))["\'].*?>/i';
        preg_match_all($pattern, $content, $matches);

        $gambarBase64 = $matches[1];
        $masjidId = auth()->user()->masjid_id;

        foreach ($gambarBase64 as $gambar) {
            $data = explode(',', $gambar);
            $gambarData = $data[1];
            $mime = $data[0];
            $finfo = finfo_open();
            $ext = finfo_buffer($finfo, base64_decode($gambarData), FILEINFO_MIME_TYPE);
            finfo_close($finfo);
            $ext = explode('/', $ext)[1];

            $namaFile = "profil/$masjidId/" . uniqid() . '.' . $ext;
            Storage::disk('public')->put($namaFile, base64_decode($gambarData));

            $namaFile = "/storage/$namaFile";
            $content = str_replace($gambar, $namaFile, $content);
        }

        return $content;
    }

    public function setContentAttribute($key, $value)
    {
        if ($key === $this->contentName) {
            $value = $this->convertBase64ImagesToUrls($value);
        }
        return parent::setAttribute($key, $value);
    }
}
