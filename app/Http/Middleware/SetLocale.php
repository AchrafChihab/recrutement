<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{

    
    public function handle($request, Closure $next)
    { 
        $locale = $request->has('locale') ? $request->get('locale') : 'fr';
        
        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}
