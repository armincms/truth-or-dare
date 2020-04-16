<?php

namespace Armincms\TruthOrDare\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use OptimistDigital\MultiselectField\Multiselect;
use Armincms\RawData\Common;

class Question extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\TruthOrDare\\Question';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'question';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        "question"
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
            ID::make()->sortable(),

            Boolean::make(__('This is a dare question?'), 'truth') 
                ->sortable() 
                ->values(false, true) 
                ->default(0)
                ->onlyOnForms(),

            Text::make(__('Question'), 'question')
                ->sortable()
                ->required()
                ->rules('required'),

            BelongsTo::make(__('Theme'), 'theme', Theme::class)
                ->withoutTrashed()
                ->default(Theme::$model::whereDefault(1)->first()),  

            Boolean::make(__('Truth'), function() {
                return $this->truth;
            })->sortable()->exceptOnForms(),

            Select::make(__('Level'), 'level')
                ->options(Common::levels()) 
                ->displayUsingLabels() 
                ->sortable() 
                ->default(Common::levels()->keys()->first()),

            Multiselect::make(__('Gender'), 'gender')
                ->options(Common::genders())
                ->saveAsJSON() 
                ->sortable() 
                ->help(__("Leave blank to select all"))
                ->fillUsing([$this, 'fillUsingMultiselect'])
                ->resolveUsing(function($value) {
                    return $this->resolveUsingMultiselect($value, Common::genders()->keys()->all());
                }),

            Multiselect::make(__('Marital Status'), 'marital')
                ->options(Common::maritals())
                ->saveAsJSON()
                ->sortable()
                ->help(__("Leave blank to select all"))
                ->fillUsing([$this, 'fillUsingMultiselect'])
                ->resolveUsing(function($value) {
                    return $this->resolveUsingMultiselect($value, Common::maritals()->keys()->all());
                }),

            Multiselect::make(__('Age'), 'age')
                ->options(Common::ages())
                ->saveAsJSON() 
                ->sortable() 
                ->help(__("Leave blank to select all"))
                ->fillUsing([$this, 'fillUsingMultiselect'])
                ->resolveUsing(function($value) {
                    return $this->resolveUsingMultiselect($value, Common::ages()->keys()->all());
                })
                ->hideFromIndex(),
        ];
    } 

    public function fillUsingMultiselect($request, $model, $attribute, $requestAttribute) {
        $value = implode(',', (array) $request->get($requestAttribute));

        $model->$attribute = empty($value) ? null : $value;
    } 

    public function resolveUsingMultiselect($value = null, $values)
    {  
        return (app('request')->editing || $value) ? $value : $values;
    }
}
