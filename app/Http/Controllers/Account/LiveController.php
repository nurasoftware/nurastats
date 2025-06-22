<?php

namespace App\Http\Controllers\User;

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
use mvnrsa\LiveCharts\Http\Livewire\LiveCharts\BarChart;


class LiveController extends BarChart 
{


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
        $live_date_start = Carbon::now()->subMinutes(180)->toDateTimeString();
        $builder = LogSession::where('site_id', $site->id)->where('created_at', '>=', $live_date_start)->select(
            //DB::raw("DATE_FORMAT(created_at, '%H:%i') as date"),
            DB::raw('"'.$live_date_start.'" AS `date`'),
            //DB::raw("DATE_FORMAT(NOW(), '%H:%i') as date"),
            DB::raw('FLOOR(1+rand()*10) AS `cnt 1`'),
        )
            //->groupBy(DB::raw("DATE(created_at)"))
            ->groupBy("created_at")
            //->orderBy('visitors')
        ;


        //dd($builder);

        return view('account.index', [
            'view_file' => 'stats.live',
            'active_menu' => 'live',
            'site' => $site,

            'data' => $data,
            'builder' => $builder,
        ]);
    }
}
