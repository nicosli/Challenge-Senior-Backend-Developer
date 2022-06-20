<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;

    /**
     * Table with all addresses
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * Timestamps disable
     *
     * @var bool
     */
    public $timestamps = false;
}
