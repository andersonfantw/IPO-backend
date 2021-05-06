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
}
