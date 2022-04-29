<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Support\Facades\Log;

class NoShopException extends Exception
{
    //
     /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        Log::debug('Shop not found');
    }
 
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response('no shop found');
    }
}
