<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Http\Controllers\UncompressFile;

class XMLHandler extends Controller
{
    /**
     * Read xml file and put the information to database
     *
     * @return void
     */
    public static function dump(){
        $baseFile = base_path() . "/resources/data";
        
        $zip = $baseFile . "/CPdescargaxml.zip";
        UncompressFile::run($zip);
        
        // Read file from storage
        $file = base_path() . "/resources/data/CPdescarga.xml";
        $xml = @simplexml_load_file($file) or die ("Error while loading: ".$file."\n");
        
        echo "Saving data..." . PHP_EOL;
        // Loop to get data from xml object
        foreach($xml->table as $val){

            // New Model Instance of Addresses, to save the data
            $add = new Addresses;

            $add->d_codigo = $val->d_codigo;
            $add->d_asenta = $val->d_asenta;
            $add->d_tipo_asenta = $val->d_tipo_asenta;
            $add->D_mnpio = $val->D_mnpio;
            $add->d_estado = $val->d_estado;
            $add->d_ciudad = $val->d_ciudad;
            $add->d_CP = $val->d_CP;
            $add->c_estado = $val->c_estado;
            $add->c_oficina = $val->c_oficina;
            $add->c_CP = $val->c_CP;
            $add->c_tipo_asenta = $val->c_tipo_asenta;
            $add->c_mnpio = $val->c_mnpio;
            $add->id_asenta_cpcons = $val->id_asenta_cpcons;
            $add->d_zona = $val->d_zona;
            $add->c_cve_ciudad = $val->c_cve_ciudad;

            $add->save();
            echo $val->d_codigo . " saved \n";
        }

        echo "The data has been saved..." . PHP_EOL;

        UncompressFile::removeFile($file);
    }
}
