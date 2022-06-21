<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use Illuminate\Support\Facades\Cache;

class DataCache extends Controller
{
    /**
     * Save the data into cache (redis)
     *
     * @return void
     */
    public static function store(){
        // clean all cache
        Cache::flush();

        // get all data from database
        $addresses = Addresses::all()->toArray();
        
        // loop to save data in cache
        foreach($addresses as $address){
            echo "saving to cache " . $address["d_codigo"] . PHP_EOL;

            if(Cache::has($address["d_codigo"])){
                // pull and destroy this cache
                $item = Cache::pull($address["d_codigo"]);
                // add the new data to the array
                array_push($item, $address);

                // save the data to cache
                Cache::forever($address["d_codigo"], $item);
            } else {

                // save the data to cache
                Cache::forever($address["d_codigo"], [$address]);
            }
        }
    }
}
