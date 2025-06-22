<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ErrorPage;
use Illuminate\Support\Str;
use Auth;
use App\Models\Site;
use App\Models\StatusChecker;


class HealthController extends Controller
{

    public function __construct(Request $request) {}

    /**
     * Website status checker dashboard
     */
    public function error_pages(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        $pages = ErrorPage::where('site_id', $site->id)->orderByDesc('id')->paginate(25);

        return view('user.index', [
            'view_file' => 'health.error-pages',
            'active_menu' => 'health',
            'active_submenu' => 'error-pages',  
            'site' => $site,
            'pages' => $pages,
        ]);
    }


    public function status_checker(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        $last_checks = StatusChecker::where('site_id', $site->id)->orderByDesc('id')->limit(25)->get();

        $last_checks_reverse = $last_checks->reverse();
        
        $stats_bars = StatusChecker::website_stats($site->id);

        return view('user.index', [
            'view_file' => 'health.status-checker',
            'active_menu' => 'health',
            'active_submenu' => 'status-checker',
            'site' => $site,
            'stats_bars' => $stats_bars,
            'last_checks' => $last_checks,
            'last_checks_reverse' => $last_checks_reverse,
        ]);
    }


   
}
