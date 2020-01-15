<?php

namespace App\Models\Curriculums;

use Illuminate\Database\Eloquent\Model;

class CurriculumItems extends Model
{
    protected $table = 'curriculum_item';
    protected $primaryKey = 'curriculum_item_id';
    public $timestamps = false;
}
