<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentOption extends Model
{
    use HasFactory;

    protected $guraded = [];

    public function assessmentQuestion()
    {
        return $this->belongsTo(AssessmentQuestion::class);
    }
}