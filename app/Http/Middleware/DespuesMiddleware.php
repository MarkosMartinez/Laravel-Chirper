<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DespuesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    try {
        $response = $next($request);

        $users = DB::table('users')->get();
        $usuarios = [];
        foreach ($users as $user) {
            $usuarios[] = $user->name;
        }

        Log::info('Mensaje cargado despues! Usuarios en la DB: ' . implode(', ', $usuarios));
        return $response;
    } catch (\Exception $e) {
        Log::error('Error en el middleware: ' . $e->getMessage());
        return response('Error en el middleware', 500);
    }
}

}
