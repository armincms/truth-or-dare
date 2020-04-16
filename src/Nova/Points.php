<?php

namespace Armincms\TruthOrDare\Nova;
  
use Illuminate\Http\Request;  
use Laravel\Nova\Fields\Number; 
use Armincms\Nova\ConfigResource as Resource; 
use Armincms\RawData\Common;

class Points extends Resource
{    
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = "Truth Or Dare"; 
 
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    { 
        return Common::levels()->map(function($label, $level) {
            return Number::make(__(":level level points coefficient", compact('level')), $level)
                        ->min(1)
                        ->rules('min:1')
                        ->withMeta(['value' => 1]);
        })->all(); 
    }
}
