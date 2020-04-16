<?php

namespace Armincms\TruthOrDare;
 

class Consequence extends Question
{ 
	public function themes()
	{
		return $this->morphToMany(Theme::class, 'themeable', 'tod_themeable');
	} 

	public function getLevelAttribute($value)
	{
		return $this->getSetValue($value);
	} 
}
