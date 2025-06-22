<?php

/**
 * NuraStats - Open source and privacy-friendly web analytics.
 * https://nurastats.com
 *
 * Copyright (c) Chimilevschi Iosif Gabriel
 * LICENSE:
 * Permissions of this strongest copyleft license are conditioned on making available complete source code 
 * of licensed works and modifications, which include larger works using a licensed work, under the same license. 
 * Copyright and license notices must be preserved. Contributors provide an express grant of patent rights. 
 * When a modified version is used to provide a service over a network, the complete source code of the modified version must be made available.
 *    
 * @copyright   Copyright (c) Chimilevschi Iosif Gabriel
 * @license     https://opensource.org/license/agpl-v3  AGPL-3.0 License.
 * @author      Chimilevschi Iosif Gabriel <office@nurasoftware.com>
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Site;
use Auth;

class LoggedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::user()) {

            // Update last activity
            User::where('id', Auth::user()->id)->update(['last_activity_at' => now()]);

            Facades\View::composer('*', function (View $view) {
                $sidebar_websites = Site::where('user_id', Auth::user()->id)->where('active', 1)->orderByDesc('active')->orderByDesc('favourite')->orderBy('label')->get();
                $view->with('sidebar_websites', $sidebar_websites);
            });
        }

        return $next($request);
    }
}
