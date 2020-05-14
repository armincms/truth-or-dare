<?php

namespace Armincms\TruthOrDare\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Select; 
use Laravel\Nova\Fields\HasOne; 
use Armincms\Fields\BelongsToMany; 
use Armincms\Fields\MorphToMany; 
use Armincms\RawData\Common;

class Player extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\TruthOrDare\\Player';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

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
            ID::make('ID')
                ->sortable(),  

            Text::make(__('Name'), 'name')
                ->sortable()
                ->required()
                ->rules('required'),

            Select::make(__('Age'), 'age')
                ->options(Common::ages()) 
                ->displayUsingLabels() 
                ->sortable() 
                ->default(Common::ages()->keys()->first()),

            Select::make(__('Gender'), 'gender')
                ->options(Common::genders()) 
                ->displayUsingLabels() 
                ->sortable() 
                ->default(Common::genders()->keys()->first()),

            Select::make(__('Marital'), 'marital')
                ->options(Common::maritals()) 
                ->displayUsingLabels() 
                ->sortable() 
                ->default(Common::maritals()->keys()->first()), 

            BelongsToMany::make(__('Game'), 'games', Game::class)
                ->sortable(),

        ];
    } 

    public static function defaultQuery()
    {
        return static::$model::whereDefault(1);
    }
}
