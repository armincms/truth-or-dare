<?php

namespace Armincms\TruthOrDare;

use Armincms\Contracts\Authorizable;
use Armincms\Concerns\Authorization; 

class Player extends Model implements Authorizable
{  
	use Authorization;
	
	public function games()
	{
		return $this->belongsToMany(Game::class, 'tod_game_player');
	}
}
