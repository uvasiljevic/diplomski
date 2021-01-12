<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class User extends ModelUV
{
    protected $tableName = 'user';
    protected $table     = 'uv_user';
    public $timestamps   = false;

    use HasFactory;
}
