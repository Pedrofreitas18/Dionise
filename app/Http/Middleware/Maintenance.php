<?php
namespace App\Http\Middleware;

class Maintenance{
    public function handle($request, $next){
        if(getenv('MAINTENANCE') == 'true'){
            throw new \Exception("Problema ao processar", 500);
        }
        return $next($request);
    }
}