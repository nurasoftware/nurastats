<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Site;
use App\Models\LogSession;
use App\Models\LogVisitor;
use App\Models\StatsRecent;
use DB;

class UpdateStatsRecentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sites = Site::where('active', 1)->where('clevada_status', 'active')->orderByDesc('id')->get();

        foreach ($sites as $site) {
            $site_host = $site->url;
            if (substr($site_host, 0, 4) == 'www.') $site_host = str_replace('www.', '', $site_host);
            if (substr($site_host, 0, 7) == 'http://') $site_host = str_replace('http://', '', $site_host);
            if (substr($site_host, 0, 8) == 'https://') $site_host = str_replace('https://', '', $site_host);

            $this->info('Site: ' . $site->url);
            $this->info('Host: ' . $site_host);

            $start_date = date('Y-m-d', strtotime("-1 month", strtotime(date('Y-m-d'))));
            $this->info('Start date: ' . $start_date);
            $end_date = date('Y-m-d');

            $start = new \DateTime($start_date);
            $end = new \DateTime($end_date);

            $data_stats = [];
            $loc_stats = [];

            for ($date = $start; $date <= $end; $date->modify('+1 day')) {
                $d = $date->format("Y-m-d");

                // Traffic stats                
                $visitors_count = LogVisitor::where('site_id', $site->id)->whereDate('created_at', $d)->count();
                $views_count = LogSession::where('site_id', $site->id)->whereDate('created_at', $d)->count();
                $this->info('Date: ' . $d . ' | Visitors: ' . $visitors_count . ' | Views: ' . $views_count);
                //$data_stats[] = ['day' => $d, 'visitors' => $visitors_count, 'views' => $views_count];

                // Location data
                $c_array = [];
                $visitors_countries = LogVisitor::where('site_id', $site->id)->whereDate('created_at', $d)
                    ->select(DB::raw('count(geo_cc) as countries_count, geo_cc, geo_country'))->groupBy('geo_cc')->get();

                foreach ($visitors_countries as $country) {
                    $c_array[] = ['code' => $country->geo_cc, 'country' => $country->geo_country, 'counter' => $country->countries_count];
                }

                // order countries array by counter
                $column = array_column($c_array, 'counter');
                array_multisort($column, SORT_DESC, $c_array);


                // Devices data
                $dev_array = [];
                $visitors_devices = LogVisitor::where('site_id', $site->id)->where('device_type', '!=', 'b')->whereDate('created_at', $d)
                    ->select(DB::raw('count(device_type) as device_type_count, device_type'))->groupBy('device_type')->get();

                foreach ($visitors_devices as $device) {
                    $dev_array[] = ['type' => $device->device_type, 'counter' => $device->device_type_count];
                }

                // order countries array by counter
                $column_devices = array_column($dev_array, 'counter');
                array_multisort($column_devices, SORT_DESC, $dev_array);

                // AVERAGE TIME      
                $seconds_min_value = 0;
                $seconds_min_items = LogSession::where('site_id', $site->id)->whereDate('created_at', $d)->whereNotNull('seconds_min')->count();
                if ($seconds_min_items > 0) {
                    $seconds_min_total = LogSession::where('site_id', $site->id)->whereDate('created_at', $d)->whereNotNull('seconds_min')->sum('seconds_min');
                    $seconds_min_value = round($seconds_min_total / $seconds_min_items);
                }

                // REFERRERS                
                $ref_array = [];
                $ref_sessions = LogSession::where('site_id', $site->id)->whereDate('created_at', $d)->where('referrer_host', '!=', $site_host)
                    ->select(DB::raw('count(referrer_host) as referrer_host_count, referrer_host'))->groupBy('referrer_host')->get();

                foreach ($ref_sessions as $ref_session) {
                    if (!$ref_session->referrer_host) continue;
                    if ($site_host == $ref_session->referrer_host) continue; // exclude referrers from internal website
                    $ref_array[] = ['host' => $ref_session->referrer_host, 'counter' => $ref_session->referrer_host_count];
                }

                // order referrers array by counter
                $column = array_column($ref_array, 'counter');
                array_multisort($column, SORT_DESC, $ref_array);


                // TOP PAGES
                $pages_array = [];
                $top_pages = LogSession::with('page')->where('site_id', $site->id)->whereDate('created_at', $d)
                    ->select(DB::raw('count(page_id) as page_count, page_id'))->groupBy('page_id')->get();
                foreach ($top_pages as $top_page) {
                    if(!$top_page->page) continue;
                    $pages_array[] = ['url' => $top_page->page->page, 'title' => $top_page->page->title, 'counter' => $top_page->page_count, 'page_hash' => $top_page->page->hash];
                }

                // order referrers array by counter
                $column = array_column($pages_array, 'counter');
                array_multisort($column, SORT_DESC, $pages_array);

                StatsRecent::updateOrCreate(
                    ['site_id' => $site->id, 'day' => $d],
                    [
                        'last_day' => $end_date,
                        'visitors' => $visitors_count,
                        'views' => $views_count,
                        'average_time' => $seconds_min_value ?? null,
                        'countries' => json_encode($c_array),
                        'devices' => json_encode($dev_array),
                        'referrers' => json_encode($ref_array),
                        'top_pages' => json_encode($pages_array),
                    ]
                );
            }
        }
    }
}
