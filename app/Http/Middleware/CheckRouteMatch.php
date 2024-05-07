<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Api_Secure;

class CheckRouteMatch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        // Assuming API key is passed in the Authorization header
        $apiKey = "/api/FB";

        // Retrieve the route from the database based on the API key
        $apiSecure = Api_Secure::where('api_key_route', $apiKey)->first();
        
        if ($apiSecure) {
            $savedRoute = strtok($apiSecure->api_key_route, '?'); // Extract only the route part
            $requestedRoute = strtok($request->getRequestUri(), '?'); // Extract only the route part from the request URI
        
            // Log the values for debugging
            \Log::info('Saved Route: ' . $savedRoute);
            \Log::info('Requested Route: ' . $requestedRoute);
        
            if ($savedRoute === $requestedRoute) {
                return $next($request); // Route matches, allow access to the endpoint
            } else {
                return response()->json(['error' => 'Unauthorized access'], 403); // Route does not match, return 403 Forbidden
            }
        } else {
            return response()->json(['error' => 'API key not found'], 404); // API key not found, return 404 Not Found
        }
        
    }
}
