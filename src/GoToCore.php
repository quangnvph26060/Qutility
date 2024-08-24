<?php

namespace Wuang\Qutility;

use Closure;

class GoToCore{

    public function handle($request, Closure $next)
    {
        $fileExists = file_exists(__DIR__.'/wuang.json');
        if ($fileExists && env('PURCHASECODE')) {
            return redirect()->route(Wuang::acDRouter());
        }
        return $next($request);
    }
}