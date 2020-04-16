<?php

namespace Armincms\TruthOrDare\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID; 
use Laravel\Nova\Fields\Number; 
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\BelongsTo;  

class Stage extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\TruthOrDare\\Stage';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
    ]; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return[
            ID::make("ID")->sortable(),   

            Boolean::make(__("Passed"), 'passed'),

            Number::make(__("Stage"), 'stage')
                ->required()
                ->rules('required')
                ->default(0),

            BelongsTo::make(__("Player"), 'player', Player::class)
                ->sortable()
                ->required()
                ->withoutTrashed()
                ->rules("required"),

            BelongsTo::make(__("Game"), 'game', Game::class)
                ->sortable()
                ->required()
                ->withoutTrashed()
                ->rules("required"),

            BelongsTo::make(__("Question"), 'question', Question::class)
                ->sortable()
                ->required()
                ->withoutTrashed()
                ->rules("required"),

            BelongsTo::make(__("Consequence"), 'consequence', Consequence::class)
                ->sortable()
                ->nullable()
                ->withoutTrashed(),
        ];
    } 

    public static function defaultQuery()
    {
        return static::$model::whereDefault(1);
    }
}
