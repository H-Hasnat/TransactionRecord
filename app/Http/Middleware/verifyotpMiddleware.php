<?php

namespace App\Http\Middleware;

use APP\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class verifyotpMiddleware
{
    public function handle(Request $request, Closure $next): Response

    {

        $token=$request->cookie('token');
        $res=JWTToken::verifyToken($token);
        if($res==='unauthorized'){
            return redirect('/');
        }else{
            $request->headers->set('number',$res->number);
            $request->headers->set('id',$res->userid);
            return $next($request);

        }
    }
}
