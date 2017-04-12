<?php namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class Language {

      public function handle($request, Closure $next)

      {
        //die(Session::has('lang') ? Session::get('lang') : Config::get('app.locale'));
        //App::setLocale(Session::has('lang') ? Session::get('lang') : Config::get('app.locale'));
        //session()->put('locale',Session::has('lang') ? Session::get('lang') : Config::get('app.locale'));
        //dd(session()->get());

        return $next($request);

      }

    

    }