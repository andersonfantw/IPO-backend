<?php
namespace App\Traits;

trait FileToBase64
{
    public function fileToBase64($file)
    {
        $file_path = $file->path();
        $this->filePathToBase64($file_path);
    }

    public function filePathToBase64(String $file_path)
    {
        $file_contents = file_get_contents($file_path);
        $base64 = base64_encode($file_contents);
        return $base64;
    }
}
