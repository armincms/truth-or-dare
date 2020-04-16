<?php

namespace Armincms\TruthOrDare;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends LaravelModel
{
	use SoftDeletes; 

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {  
    	return (starts_with(parent::getTable(), "tod_") ? "" : "tod_") . parent::getTable();
    }  

    public static function levels()
    {
        return [
            'easy'   => __('Easy'),
            'normal' => __('Normal'),
            'hard'   => __('Hard'),
            'expert' => __('Expert'),
        ];
    } 
}
