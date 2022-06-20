<?php

namespace App\Http\Controllers;

use ZipArchive;

class UncompressFile extends Controller
{
    /**
     * 
     *
     * @return void
     */
    public static function run($file_name){
        
        $zip = new ZipArchive();
        $status = $zip->open($file_name);
        if ($status !== true) {
            throw new \UnexpectedValueException('Could not open destination file');
        }
        else{
            echo "Extracting zip content..." . PHP_EOL;
            $storageDestinationPath= base_path() . "/resources/data";
            $zip->extractTo($storageDestinationPath);
            $zip->close();
        }
    }

    /**
     * 
     *
     * @return void
     */
    public static function removeFile($file_name){
        if (file_exists($file_name)) {
            unlink($file_name);
        }
    }
}
