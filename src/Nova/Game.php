<?php

namespace Armincms\TruthOrDare\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Select; 
use Laravel\Nova\Fields\HasMany;  
use Armincms\Fields\BelongsToMany; 
use Armincms\RawData\Common;

class Game extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\TruthOrDare\\Game';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'game';

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 25;

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
            ID::make('ID')->sortable(), 

            $this->authField(),

            Text::make(__('Game Id'), function() {
                return $this->game;
            })->sortable(), 

            Select::make(__('Level'), 'level')
                ->options(Common::levels()) 
                ->displayUsingLabels() 
                ->sortable() 
                ->default(Common::levels()->keys()->first()),

            BelongsToMany::make(__('Themes'), 'themes', Theme::class),

            BelongsToMany::make(__('Players'), 'players', Player::class),

            HasMany::make(__('Stages'), 'stages', Stage::class),

        ];
    } 

    public static function defaultQuery()
    {
        return static::$model::whereDefault(1);
    }
}
