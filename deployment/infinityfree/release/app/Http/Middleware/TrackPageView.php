<?php

namespace App\Http\Middleware;

use App\Services\AnalyticsLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    public function __construct(private AnalyticsLogger $analytics) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if ($request->isMethod('GET') && $request->header('DNT') !== '1'
            && $response->isSuccessful() && ! $request->expectsJson()) {
            $this->analytics->log('page_view', ['path' => '/' . ltrim($request->path(), '/')]);
        }
        return $response;
    }
}
