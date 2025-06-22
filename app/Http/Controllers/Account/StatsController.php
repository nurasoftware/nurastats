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

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteUser;
use App\Models\LogSession;
use App\Models\LogVisitor;
use App\Models\StatsRecent;
use App\Models\LogPage;
use Auth;
use DB;
use Illuminate\Support\Carbon;

class StatsController extends Controller
{

    public function __construct(Request $request) {}

    /**
     * Show stats dashboard
     */
    public function index(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        //$stat_h_visitors = Visitor::where('site_id', $site->id)->where('created_at', '>=', now()->subHour())->count();
        //$stat_h_views = LogSession::where('site_id', $site->id)->where('first', '>=', now()->subHour())->count();

        $date_today = date('Y-m-d');
        $date_yesterday = date('Y-m-d', strtotime("-1 days"));
        $date_7_days_ago = date('Y-m-d', strtotime("-7 days"));
        $date_30_days_ago = date('Y-m-d', strtotime("-30 days"));

        $stats_today_visitors = LogVisitor::where('site_id', $site->id)->whereDate('created_at', $date_today)->count();
        $stats_today_views = LogSession::where('site_id', $site->id)->whereDate('created_at', $date_today)->count();

        $stats_yesterday_visitors = LogVisitor::where('site_id', $site->id)->whereDate('created_at', $date_yesterday)->count();
        $stats_yesterday_views = LogSession::where('site_id', $site->id)->whereDate('created_at', $date_yesterday)->count();

        $stats_last_7_days_visitors = LogVisitor::where('site_id', $site->id)->whereDate('created_at', '>=', $date_7_days_ago)->count();
        $stats_last_7_days_views = LogSession::where('site_id', $site->id)->whereDate('created_at', '>=', $date_7_days_ago)->count();

        $stats_last_30_days_visitors = LogVisitor::where('site_id', $site->id)->whereDate('created_at', '>=', $date_30_days_ago)->count();
        $stats_last_30_days_views = LogSession::where('site_id', $site->id)->whereDate('created_at', '>=', $date_30_days_ago)->count();

        $recent_visitors = LogVisitor::withCount('sessions')->where('site_id', $site->id)->orderByDesc('id')->limit(25)->get();
        $recent_pages = LogSession::with('page')->where('site_id', $site->id)->orderByDesc('id')->limit(35)->get();
        $recent_distinct_pages = collect($recent_pages)->unique('page_id');

        $chart_date_start = date('Y-m-d', strtotime("-14 days"));
        $stats_traffic = StatsRecent::where('site_id', $site->id)->where('day', '>=', $chart_date_start)->where('day', '<', date('Y-m-d'))->get();

        return view('account.index', [
            'view_file' => 'stats.index',
            //'active_menu' => 'site_' . $site->code,            
            //'active_submenu' => 'dashboard',
            'active_menu' => 'overview',
            'site' => $site,
            'recent_visitors' => $recent_visitors,
            'recent_distinct_pages' => $recent_distinct_pages,

            'stats_today_visitors' => $stats_today_visitors,
            'stats_today_views' => $stats_today_views,

            'stats_yesterday_visitors' => $stats_yesterday_visitors,
            'stats_yesterday_views' => $stats_yesterday_views,

            'stats_last_7_days_visitors' => $stats_last_7_days_visitors,
            'stats_last_7_days_views' => $stats_last_7_days_views,

            'stats_last_30_days_visitors' => $stats_last_30_days_visitors,
            'stats_last_30_days_views' => $stats_last_30_days_views,

            'stats_traffic' => json_decode($stats_traffic),

            'date_today' => $date_today,
            'date_yesterday' => $date_yesterday,
            'date_7_days_ago' => $date_7_days_ago,
            'date_30_days_ago' => $date_30_days_ago,
        ]);
    }



    /**
     * Pages stats
     */
    public function pages(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        /*
        $range = $request->range;
        $pages = LogSession::with('page')->where('site_id', $site->id)
            ->select(DB::raw('count(page_id) as sessions_count, page_id'), DB::raw('count(distinct visitor_id) as visitors_count'));

        if ($range) {
            $range_array = explode('_', $range);
            $start = $range_array[0];
            $end = $range_array[1];
        } else {
            $start = date('Y-m-d', strtotime("-7 days"));
            $end = date("Y-m-d");
        }

        if ($start == $end)
            $pages = $pages->whereDate('created_at', $start);
        else
            $pages = $pages->whereBetween('created_at', [$start, $end]);
        */
        //dd($start);

        /*
        $pages = $pages->addSelect(['count_sessions' => function (Builder $builder) use($site) {
            $builder->from('log_session')->selectRaw('count(DISTINCT page_id)');
        }]);
        
        //$pages = $pages->orderByDesc(DB::raw("count(page_id)"));
        //$pages = $pages->sortBy('count_session');
        //$pages = $pages->groupBy('page_id')->limit(100)->get()->sortByDesc('count_session');

        $pages = $pages->groupBy('page_id')
            ->orderByDesc('sessions_count')
            ->paginate(25);
        */

        //dd($pages);
        /*
        $items = SessionData::where('page_hash', '')->get();        
        foreach($items as $item) {
            $hash = md5($item->domain.$item->page);
            SessionData::where('id', $item->id)->update(['page_hash' => $hash]);
        }
        */

        $pages = LogSession::with('page')->where('site_id', $site->id)->orderByDesc('id')->paginate(25);

        return view('account.index', [
            'view_file' => 'stats.pages',
            //'active_menu' => 'site_' . $site->code,
            //'active_submenu' => 'pages',
            'active_menu' => 'pages',

            'site' => $site,
            'pages' => $pages,
            //'range_start' => $start,
            //'range_end' => $end,

            //'date_today' => date('Y-m-d'),
            //'date_yesterday' => date('Y-m-d', strtotime("-1 days")),
            //'date_7_days_ago' => date('Y-m-d', strtotime("-7 days")),
            //'date_30_days_ago' => date('Y-m-d', strtotime("-30 days")),
        ]);
    }


    /**
     * Visitors stats
     */
    public function visitors(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        /*
        $range = $request->range;
        $visitors = Visitor::withCount('sessions')->where('site_id', $site->id);
        if ($range) {
            $range_array = explode('_', $range);
            $start = $range_array[0];
            $end = $range_array[1];
        } else {
            $start = date('Y-m-d', strtotime("-7 days"));
            $end = date("Y-m-d");
        }
        if ($start == $end)
            $visitors = $visitors->whereDate('created_at', $start);
        else
            $visitors = $visitors->whereBetween('created_at', [$start, $end]);
        $visitors = $visitors->orderByDesc('id')->paginate(25);
        */

        $visitors = LogVisitor::withCount('sessions')->where('site_id', $site->id)->orderByDesc('id')->paginate(25);

        return view('account.index', [
            'view_file' => 'stats.visitors',
            //'active_menu' => 'site_' . $site->code,
            //'active_submenu' => 'visitors',
            'active_menu' => 'visitors',
            'site' => $site,
            'visitors' => $visitors,
            //'range_start' => $start,
            //'range_end' => $end,

            //'date_today' => date('Y-m-d'),
            //'date_yesterday' => date('Y-m-d', strtotime("-1 days")),
            //'date_7_days_ago' => date('Y-m-d', strtotime("-7 days")),
            //'date_30_days_ago' => date('Y-m-d', strtotime("-30 days")),
        ]);
    }


    /**
     * Page stats
     */
    public function page_stats(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $page = LogPage::where('hash', $request->hash)->first();
        if (!$page) return redirect(route('user.sites.index'));

        $sessions = LogSession::with('visitor')->where(['site_id' => $site->id, 'page_id' => $page->id])->orderByDesc('id')->paginate(25);

        return view('account.index', [
            'view_file' => 'stats.page-stats',
            //'active_menu' => 'site_' . $site->code,
            //'active_submenu' => 'pages',
            'active_menu' => 'pages',
            'site' => $site,
            'page' => $page,
            'sessions' => $sessions,
        ]);
    }



    /**
     * Show live dashboard
     */
    public function live(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));

        // check permission
        if (SiteUser::where('site_id', $site->id)->where('role', 'admin')->where('user_id', Auth::user()->id)->doesntExist()) return redirect(route('user.sites.index'));

        $chart_date_start = date('Y-m-d', strtotime("-1 days"));
        $data = StatsRecent::where('site_id', $site->id)->where('day', '>=', $chart_date_start)->get();

        /*
        $builder = LogSession::where('site_id', $site->id)->where('created_at', '>=', $chart_date_start)->select(
            DB::raw("DATE_FORMAT(created_at, '%H:%i') as date"),
            //DB::raw("COUNT(DATE_FORMAT(created_at, '%H:%i:%s')) as cnt")
            DB::raw("COUNT(0) as cnt")
        )
            //->groupBy(DB::raw("DATE(created_at)"))
            ->groupBy("created_at")
            //->orderBy('visitors')
        ;
        */
        $live_date_start = Carbon::now()->subMinutes(280)->toDateTimeString();
        $builder = LogSession::where('site_id', $site->id)->where('created_at', '>=', $live_date_start)->select(
            //DB::raw("DATE_FORMAT(created_at, '%H:%i') as date"),
            DB::raw("TIMEDIFF('2017-06-25 13:10:11', '2017-06-15 13:10:10') as date"),
            //DB::raw('"'.$live_date_start.'" AS `date`'),
            //DB::raw("SELECT COUNT('id') DATE_FORMAT(NOW(), '%H:%i') as cnt1"),
            //DB::raw("COUNT(id) WHERE site_id = 5 as cnt1"),
            DB::raw('FLOOR(1+rand()*10) AS `cnt 1`'),

        )
            //->groupBy(DB::raw("DATE(created_at)"))
            ->groupBy("created_at")
            //->orderBy('visitors')
        ;


        //dd($builder);

        return view('account.index', [
            'view_file' => 'stats.live2',
            'active_menu' => 'live',
            'site' => $site,

            'data' => $data,
            'builder' => $builder,
        ]);
    }
}
