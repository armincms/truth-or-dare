<?php

namespace Armincms\Koomeh\Nova\Actions;
 
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;  
use Armincms\Tools\ToolbarAction\Action; 
use Armincms\Koomeh\ResidencesUsage;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class ImportTheUsages extends Action
{  
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    { 
        $usages = ResidencesUsage::get()->pluck("usage"); 

        $insertions = Collection::make($this->usages())->reject(function($usage) use ($usages) {
            return $usages->contains($usage);
        });

        ResidencesUsage::insert($insertions->map(function($icon) {
            return compact("icon");
        })->all());  

        $usages = ResidencesUsage::whereDoesntHave('translations')->get()->pluck("id")->all();

        (new ResidencesUsage)->translations()->insert($insertions->map(function($usage) use (&$usages) { 

            return [
                "usage" => $usage, 
                "residences_usage_id" => array_shift($usages),
            ];
        })->all());

        option()->put("_residences_usages_imported_", 1);
        
        return static::redirect(
            url(Nova::path().'/resources/usages-types')
        );
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [ 
        ];
    } 

    public function usages()
    {
        return [  
            __("Short Stay"),
            __("Party"), 
        ];
    }
}

