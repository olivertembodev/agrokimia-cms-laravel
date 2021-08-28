<?php

namespace App\Classes;

use Illuminate\Support\Facades\File;
use App\Classes\S3;

class upload
{
    public function img($file)
    {
        $s3        = new S3(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
        $file_name = $file->hashName();
        $file_path = base_path('public/images/' . $file_name);
        $file->move(base_path('public/images/'), $file_name);
        $s3->putObjectFile($file_path, env('AWS_BUCKET'), $file_name, S3::ACL_PUBLIC_READ);
        File::delete($file_path);
        return env('S3_PATH') . $file_name;
    }
}
