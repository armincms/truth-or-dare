<?php

namespace Armincms\TruthOrDare\Nova;
 
use Armincms\Nova\Resource as NovaResource;  

abstract class Resource extends NovaResource
{    
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'label';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        "label"
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Truth Or Dare';   
}
