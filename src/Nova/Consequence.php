<?php

namespace Armincms\TruthOrDare\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo; 
use Armincms\Fields\BelongsToMany;
use Armincms\RawData\Common;
use OptimistDigital\MultiselectField\Multiselect;

class Consequence extends Question
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\TruthOrDare\\Consequence';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'consequence';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        "consequence"
    ]; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return collect(parent::fields($request))->map(function($field) {
            if($field->computed()) {
                return Boolean::make(__('Punishment'), function() {
                    return $this->punishment;
                })->sortable()->exceptOnForms();
            } elseif($field instanceof Text) { 
                return Text::make(__('Consequence'), 'consequence')
                    ->sortable()
                    ->required()
                    ->rules('required');
            } elseif($field instanceof Boolean) {
                return Boolean::make(__('This is punishment?'), 'punishment') 
                        ->sortable()  
                        ->default(0)
                        ->onlyOnForms();
            } elseif($field instanceof Select) {
                return Multiselect::make(__('Level'), 'level')
                    ->options(Common::levels())
                    ->saveAsJSON() 
                    ->sortable() 
                    ->help(__("Leave blank to select all"))
                    ->fillUsing([$this, 'fillUsingMultiselect'])
                    ->resolveUsing(function($value) {
                        return $this->resolveUsingMultiselect(
                            $value, Common::levels()->keys()->all()
                        );
                    });
            } elseif($field instanceof BelongsTo) {
                return BelongsToMany::make(__("Themes"), 'themes', Theme::class);
            } else {
                return $field;
            }             
        })->filter()->all(); 
    }  
}
