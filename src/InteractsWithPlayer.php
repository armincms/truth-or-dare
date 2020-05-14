<?php

namespace Armincms\TruthOrDare;
  

trait InteractsWithPlayer 
{  
    public function scopeGender($query, $gender)
    {
        $query
            ->whereNull('gender')
            ->orWhere("gender", 'like', "%{$gender}%");
    }

    public function scopeMarital($query, $marital)
    {
        $query
            ->whereNull('marital')
            ->orWhere("marital", 'like', "%{$marital}%");
    }

    public function scopeAge($query, $age)
    {
        $query
            ->whereNull('age')
            ->orWhere("age", 'like', "%{$age}%");
    }
}
