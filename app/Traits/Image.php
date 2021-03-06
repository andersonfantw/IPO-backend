<?php
namespace App\Traits;

use Storage;

trait Image
{
    use File;

    public function imageToBase64($file)
    {
        $file_path = $file->path();
        return $this->imagePathToBase64($file_path);
    }

    public function imagePathToBase64(String $file_path)
    {
        $pieces = explode('.', $file_path);
        $filetype = $pieces[count($pieces) - 1];
        $base64 = $this->filePathToBase64($file_path);
        return "data:image/$filetype;base64,$base64";
    }

    public function base64ToBlob(String $base64)
    {
        $base64 = preg_replace("/^data:image\/.+;base64,/i", '', $base64);
        return base64_decode($base64);
    }

    public function blobToBase64($blob)
    {
        $base64 = base64_encode($blob);
        return "data:image/jpeg;base64,$base64";
    }

    public function saveBase64Image(String $base64, String $file_path, String $file_name)
    {
        $extension = explode(";base64,", $base64);
        $type_aux = explode("image/", $extension[0]);
        Storage::putFileAs($file_path, $base64, "$file_name.$type_aux[1]");
        return "$file_name.$type_aux[1]";
    }

}
