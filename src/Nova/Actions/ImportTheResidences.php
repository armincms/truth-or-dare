<?php

namespace Armincms\Koomeh\Nova\Actions;
 
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;  
use Armincms\Tools\ToolbarAction\Action; 
use Armincms\Koomeh\ResidencesType;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class ImportTheResidences extends Action
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
        $residences = ResidencesType::get()->pluck("name"); 

        $insertions = Collection::make($this->residences())->reject(function($name) use ($residences) {
            return $residences->contains($name);
        });

        ResidencesType::insert($insertions->map(function($icon) {
            return compact("icon");
        })->all());  

        $residences = ResidencesType::whereDoesntHave('translations')->get()->pluck("id")->all();

        (new ResidencesType)->translations()->insert($insertions->map(function($insertion) use (&$residences) { 

            return [
                "name" => $insertion, 
                "residences_type_id" => array_shift($residences),
            ];
        })->all());

        option()->put("_residences_types_imported_", 1);
        
        return static::redirect(
            url(Nova::path().'/resources/residences-types')
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

    public function residences()
    {
        return [  
            __("Villa"),
            __("Apartment"),
            __("Suite"),
            __("Rural House"),
            __("Cottage"),
            __("Canvas Residence"),
            __("Hotel"),
            __("Boarding House"),
            __("Hostel"),
            __("Inn"),
            __("Boutique Hotel"),
            __("Tents"),
            __("Boat"),
            __("House"),
            __("Bed"),
            __("Bungalow"),
            __("Cabin"),
            __("Chalet"),
            __("Guest Suite"),
            __("Guesthouse"),
            __("Loft"),
            __("Resort"),
            __("Townhouse"),
            __("Barn"),
            __("Castle"),
            __("Cave"),
            __("Farm"),
            __("Houseboat"),
            __("Hut"),
            __("Lighthouse"),
            __("Tipi"),
            __("Treehouse"),
            __("Yurt"), 
        ];
    }
}

