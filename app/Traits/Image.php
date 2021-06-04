<?php
namespace App\Traits;

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
<<<<<<< HEAD

    public function blobToBase64(String $blob)
    {
        $base64 = base64_encode($blob);
        // $base64 = preg_replace("/^data:image\/.+;base64,/i", '', $base64);
        // return base64_decode($base64);
        return $base64;
    }

    public function saveBase64Image(String $base64, String $file_path, String $file_name)
    {
        $extension = explode(";base64,", $base64);
        $type_aux = explode("image/", $extension[0]);
        // $extension = $type_aux[1];
        Storage::putFileAs($file_path, $base64, "$file_name.$type_aux[1]");
        return "$file_name.$type_aux[1]";
    }
=======
>>>>>>> 2cb57d4bbe407af907e485fa5d37266a07660504
}
