<?php

namespace App\Helpers\Backpack;

use Illuminate\Support\Facades\Facade;

class BHtmlFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'bhtml'; }

}