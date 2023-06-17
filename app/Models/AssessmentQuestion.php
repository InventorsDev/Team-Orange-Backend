<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assessmentCondition()
    {
        return $this->belongsTo(AssessmentCondition::class);
    }

    public function assessmentOptions()
    {
        return $this->hasMany(AssessmentOption::class);
    }
}