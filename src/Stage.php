<?php

namespace Armincms\TruthOrDare;
  
class Stage extends Model 
{    
    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'player', 'game', 'question', 'consequence'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function($model) {
            while(static::whereStage($model->stage)->whereId('!=', $model->id)->exists()){
                $model->increment('stage');
            }
        });
    }


    public function player()
    {
        return $this->belongsTo(Player::class);
    } 
    
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    } 
    
    public function consequence()
    {
        return $this->belongsTo(Consequence::class);
    }  
}
