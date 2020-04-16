<?php

namespace Armincms\TruthOrDare\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Boolean; 

class Theme extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\TruthOrDare\\Theme';

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

            Text::make(__("Label"), "label")
                ->required()
                ->rules("required")
                ->sortable(), 

            Boolean::make(__("Default Theme"), 'default') 
                ->rules([function($attribute, $value, $fail) use ($request) { 
                    if($value && static::defaultQuery()->where('id', '!=', $request->resourceId)->count()) {
                        $fail(__("The default theme is set."));
                    } 
                }]) 
                ->default(0)

        ];
    } 

    public static function defaultQuery()
    {
        return static::$model::whereDefault(1);
    }
}
