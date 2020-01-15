<?php

namespace App\Models\References;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'tbsubject';
    protected $primaryKey = 'subject_id';
    public $timestamps = false;
}
