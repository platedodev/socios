<?php
/**
 * Created on 09/06/16 23:32 by https://github.com/platedodev
 * Need any support? Contact me at plateadodev@gmail.com
 * :).
 */

namespace App\Providers;

class Support
{
    public static function alertSuccess($request, $msg)
    {
        $request->session()->flash('alert-success', $msg);
    }

    public static function alertFail($request, $msg)
    {
        $request->session()->flash('alert-danger', $msg);
    }
}
