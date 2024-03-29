<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    public function educations()
    {
        return $this->hasMany(EducationExperience::class);
    }

    public function works()
    {
        return $this->hasMany(WorkExperience::class);
    }
}
