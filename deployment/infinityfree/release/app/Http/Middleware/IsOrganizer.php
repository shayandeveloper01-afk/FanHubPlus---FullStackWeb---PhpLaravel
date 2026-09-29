<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOrganizer
{
    /**
     * Allow through if the user is an organizer OR an admin.
     * Admins always have full access; organizers get event-management access only.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, ['organizer', 'admin'], true)) {
            abort(403, 'Organizer access required.');
        }

        return $next($request);
    }
}
