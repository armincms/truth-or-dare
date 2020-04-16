<?php

namespace Armincms\TruthOrDare;
 
use Armincms\Contracts\Authorizable;
use Armincms\Concerns\Authorization;

class Game extends Model implements Authorizable
{ 
	use Authorization; 

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->hasGameIdentifier() || $model->setGameIdentifier();
        });
    }

    public function hasGameIdentifier()
    {
    	return is_numeric($this->game);
    }

    public function setGameIdentifier()
    {
    	$this->attributes['game'] = time();

    	return $this;
    }

    public function getGameIdentifier()
    {  
        return $this->game;
    }
    
	public function themes()
	{
		return $this->morphToMany(Theme::class, 'themeable', 'tod_themeable');
	} 
    
    public function players()
    {
        return $this->belongsToMany(Player::class, 'tod_stages');
    } 

    public function stages()
    {
        return $this->hasMany(Stage::class);
    } 

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'tod_stages');
    }

    public function consequences()
    {
        return $this->belongsToMany(Consequence::class, 'tod_stages');
    }
}
