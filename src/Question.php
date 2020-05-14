<?php

namespace Armincms\TruthOrDare;
 

class Question extends Model
{ 
	use InteractsWithPlayer;
	
	public function theme()
	{
		return $this->belongsTo(Theme::class);
	}

	public function getMaritalAttribute($value)
	{
		return $this->getSetValue($value);
	}

	public function getAgeAttribute($value)
	{
		return $this->getSetValue($value);
	}

	public function getGenderAttribute($value)
	{
		return $this->getSetValue($value);
	}

	public function getSetValue($value = null)
	{ 
		return empty($value) ? null : explode(',', $value);
	}
}
