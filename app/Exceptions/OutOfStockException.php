<?php

namespace App\Exceptions;

use Exception;

class OutOfStockException extends Exception
{
    //
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        // \Log::debug('The product is out of stock');
    }
 
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        // return response(...);
    }
}
