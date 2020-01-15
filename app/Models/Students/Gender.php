<?php

namespace App\Models\Students;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $table = 'refgender';
    protected $primaryKey = 'gender_id';
    public $timestamps = false;
}
