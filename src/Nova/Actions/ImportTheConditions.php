<?php

namespace Armincms\Koomeh\Nova\Actions;
 
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;  
use Armincms\Tools\ToolbarAction\Action; 
use Armincms\Koomeh\ResidencesCondition;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;

class ImportTheConditions extends Action
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
        $conditions = ResidencesCondition::get()->pluck("condition");

        $insertions = Collection::make($this->conditions())->reject(function($condition) use ($conditions) {
            return $conditions->contains($condition);
        });

        ResidencesCondition::insert($insertions->map(function($insertion) { 
            return [
                'dedicated' => 0,
                'user_id'   => app(Request::class)->user()->id,
                'user_type' => app(Request::class)->user()->getMorphClass(),
            ];
        })->all());

        $keys = ResidencesCondition::whereDoesntHave('translations')->get()->modelKeys();

        (new ResidencesCondition)->translations()->insert($insertions->map(function($condition) use (&$keys) {
            return [
                "condition" => $condition,
                "residences_condition_id" => array_shift($keys),
            ];
        })->all());

        option()->put("_residences_conditions_imported_", 1);
        
        return static::redirect(
            url(Nova::path().'/resources/residences-conditions')
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

    public function conditions()
    {
        return [
            "ورود حیوانات ممنوع",
            "سیگار کشیدن ممنوع",
            "مهمانی ممنوع",
            "مهمانی کوچک مجاز",
            "سروصدا ممنوع",
            "همراه داشتن کارت شناسایی الزامی است",
            "همراه داشن مدرک محرمیت الزامیست",
        ];
    }
}
