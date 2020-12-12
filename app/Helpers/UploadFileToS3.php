<?php
namespace App\Helpers;

use Storage;

class UploadFileToS3 {

    public static function upload($file) {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $fileName = substr(md5($file->getClientOriginalName() . date("Y-m-d h:i:sa")), 15) . '.' . $file->getClientOriginalExtension();
        Storage::disk('s3')->put($fileName, file_get_contents($file));
        return $url . $fileName;
    }
    public static function uploadCrop($file) {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $fileName = $file;
        Storage::disk('s3')->put($fileName, file_get_contents($file));
        return $url . $fileName;
    }

    public static function largeFileUpload($file) {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $fileName = substr(md5($file->getClientOriginalName() . date("Y-m-d h:i:sa")), 15) . '.' . $file->getClientOriginalExtension();
        Storage::disk('s3')->put($fileName, fopen($file, 'r+'));
        return $url . $fileName;
    }

    public static function localLargeFileUpload($path) {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $name =pathinfo($path, PATHINFO_FILENAME);
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $fileName = substr(md5($name . date("Y-m-d h:i:sa")), 15) . '.' . $ext;
        Storage::disk('s3')->put($fileName, fopen($path, 'r+'));
        unlink($path);
        return $url . $fileName;
    }

    public static function delete($imageName) {
        Storage::disk('s3')->delete($imageName);
    }

    public static function getAllFile(){
        $files =  Storage::disk('s3')->files();
        return $files;
    }
}
?>
