<?php

namespace Armincms\Koomeh\Nova\Actions;
 
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;  
use Armincms\Tools\ToolbarAction\Action; 
use Armincms\Koomeh\ResidencesReservation;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class ImportTheReservations extends Action
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
        $reservations = ResidencesReservation::get(); 

        $insertions = Collection::make($this->reservations())->reject(function($reservation) use ($reservations) {
            return $reservations->where('name', $reservation['name'])->count();
        });

        ResidencesReservation::insert($insertions->map(function($reservation) { 
            $reservation = array_except($reservation, ['name', 'help']);

            return array_merge([
                'user_confirmation' => 0,
                'admin_confirmation' => 0,
                'force_payment' => 0,
                'force_reserve' => 0,
                'cancelable' => 0,
                'default' => 0,
                'active' => 0,
            ], $reservation);
        })->all());  

        $reservations = ResidencesReservation::whereDoesntHave('translations')->get();

        (new ResidencesReservation)->translations()->insert($insertions->map(function($insertion) use ($reservations) { 

            return [
                "name" => array_pull($insertion, 'name'),
                "help" => array_pull($insertion, 'help'),
                "residences_reservation_id" => $reservations->first(function($reservation) use ($insertion) {
                    $assoc = array_intersect_assoc($reservation->toArray(), $insertion);

                    return count($assoc) == count($insertion);

                })->id,
            ];
        })->all());

        option()->put("_residences_reservations_imported_", 1);
        
        return static::redirect(
            url(Nova::path().'/resources/residences-reservations')
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

    public function reservations()
    {
        return [  
            [
                "name" => "عادی",
                "active" => 1,
                "default" => 1,  
                "user_confirmation" => 1,  
            ],  
            [
                "name" => "تعاملی", 
                "help" => "امکان لغو  رزروپس از تایید میزبان",
                "cancelable" => 1, 
                "user_confirmation" => 1, 
            ],
            [
                "name" => "قطعی", 
                "force_payment" => 1,
                "force_reserve" => 1,
                "user_confirmation" => 1,
            ],
        ];
    }
}
