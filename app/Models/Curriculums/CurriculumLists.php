<?php

namespace App\Models\Curriculums;

use Illuminate\Database\Eloquent\Model;

class CurriculumLists extends Model
{
    protected $table = 'curriculum_list';
    protected $primaryKey = 'curriculum_list_id';
    public $timestamps = false;
}
