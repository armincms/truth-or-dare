<?php

namespace Armincms\TruthOrDare; 

class Player extends Model 
{  
	public function games()
	{
		return $this->belongsToMany(Game::class, 'tod_stages');
	}
}
