<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\XMLHandler;
use App\Http\Controllers\DataCache;
use App\Http\Controllers\UncompressFile;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
* Artisan command to uncompress zip file
*/
Artisan::command('UncompressFile', function() {
    UncompressFile::run(base_path() . "/resources/data/CPdescargaxml.zip");
})->purpose('Dump XML file to database');

/*
* Artisan command to remove zip file
*/
Artisan::command('removeFile', function() {
    UncompressFile::removeFile(base_path() . "/resources/data/CPdescarga.xml");
})->purpose('Dump XML file to database');

/*
* Artisan command to call XMLHandler Controller
*/
Artisan::command('XMLtoDataBase', function() {
    XMLHandler::dump();
})->purpose('Dump XML file to database');

/*
* Artisan command to save the data into cache (redis)
*/
Artisan::command('saveDataToCache', function() {
    DataCache::store();
})->purpose('save the data into cache');