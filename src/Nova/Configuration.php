<?php

namespace Armincms\Koomeh\Nova;

use Armincms\Nova\ConfigResource;  
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\Text;     
use Laravel\Nova\Fields\Select; 
use Laravel\Nova\Fields\Boolean;   

class Configuration extends ConfigResource
{      
    /**
     * Get the store tag name.
     *
     * @return string
     */
    public static function storeTag() : string
    {
        return 'residences';
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __("Residence");
    }
 
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $currencies = collect(currency()->getActiveCurrencies())->pluck("symbol", "code");

        return [ 
            Select::make(__("Currency"), "_residences_currency_")
                ->options($currencies->all()) 
                ->required()
                ->rules('required')
                ->withMeta([
                    'value' => static::option("_residences_currency_", "IRR")
                ]),

            Boolean::make(__("Onlne Reservation"), '_residences_reservation_') 
                ->required()
                ->rules('required')
                ->withMeta([
                    'value' => (int) static::option("_residences_reservation_")
                ]),
        ];
    } 
}
