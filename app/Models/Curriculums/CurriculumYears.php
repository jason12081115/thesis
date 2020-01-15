<?php

namespace App\Models\Curriculums;

use Illuminate\Database\Eloquent\Model;

class CurriculumYears extends Model
{
    protected $table = 'curriculum_year';
    protected $primaryKey = 'curriculum_year_id';
    public $timestamps = false;
}
