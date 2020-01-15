<?php

namespace App\Models\Students;

use Illuminate\Database\Eloquent\Model;

class StudentList extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $timestamps = false;
}
