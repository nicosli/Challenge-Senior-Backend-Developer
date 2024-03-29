<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Addresses;
use Validator;

class ZipcodesController extends Controller
{

    /**
     * Retrieve and map the zip code data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function get(Request $request){

        $results = "";
        $errorMessage = "";
        $codeResponse = 200;
        $input = ["zip_code" => $request->zip_code];
        $cache = false;

        // rules to validate the request
        $rules = [
            'zip_code' => 'required|numeric'
        ];

        $validator = Validator::make($input, $rules);
        
        // if the validator is true
        if ($validator->passes()) {

            if(Cache::has($request->zip_code)){
                // get array from cache and convert to a collection
                $addresses = collect(Cache::get($request->zip_code));
                $cache = true;
            } else {
                // query to get all locations with zip code
                $addresses = Addresses::where('d_codigo', '=', '%:zip_code%');
                
                // set bindings to prevent SQL Inject atack
                $addresses->setBindings([
                    'zip_code' => $request->zip_code
                ]);
    
                // Retrieve the data from database
                $addresses = $addresses->orderBy('id_asenta_cpcons', 'asc')->get()->toArray();
    
                // if the query has results
                if(count($addresses) == 0){
                    abort(404);
                } else {
                    // convert to collection
                    $addresses = collect($addresses);
                }
            }
            
            // maping the results 
            $results= [
                "zip_code" => (string)$addresses->reduce(function ($carry, $item) {
                    return $item["d_codigo"];
                }),
                "locality" => $addresses->reduce(function ($carry, $item) {
                    return strtoupper(self::replaceCharacter($item["d_ciudad"]));
                }),
                "federal_entity" => $addresses->reduce(function ($carry, $item) {
                    return [
                        "key" => (int)$item["c_estado"],
                        "name" => strtoupper(self::replaceCharacter($item["d_estado"])),
                        "code" => null
                    ];
                }),
                "settlements" => $addresses->map(function ($addresses) {
                    return [
                        "key" => (int)$addresses["id_asenta_cpcons"],
                        "name" => strtoupper(self::replaceCharacter($addresses["d_asenta"])),
                        "zone_type" => strtoupper($addresses["d_zona"]),
                        "settlement_type" => (object)["name" => $addresses["d_tipo_asenta"]]
                    ];
                }),
                "municipality" => $addresses->reduce(function ($carry, $item) {
                    return [
                        "key" => (int)$item["c_mnpio"],
                        "name" => strtoupper(self::replaceCharacter($item["D_mnpio"]))
                    ];
                }),
                "cache" => $cache
            ];


        } else {
            // if the validator is false
            $errorMessage = $validator->errors()->all();
            $results= [
                "message" => $errorMessage,
                "zip_code" => $request->zip_code
            ];
        }

        // return all content response
        return response()->json($results, $codeResponse);
    }

    public static function replaceCharacter($string) {
        $string = str_replace(
            array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'),
            array('A', 'E', 'I', 'O', 'U', 'A', 'E', 'I', 'O', 'U'),
            $string
        );

        return $string;
    }
}