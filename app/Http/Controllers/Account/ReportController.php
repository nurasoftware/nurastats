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
use App\Models\StatsRecent;

class ReportController extends Controller
{

    public function __construct(Request $request) {}

    /**
     * Show stats dashboard
     */
    public function index(Request $request)
    {
        $site = Site::where('code', $request->code)->first();
        if (!$site) return redirect(route('user.sites.index'));


        $range = $request->range;
        if ($range) {
            $range_array = explode('_', $range);
            $start = $range_array[0];
            $end = $range_array[1];
        } else {
            $start = date('Y-m-d', strtotime("-7 days"));
            $end = date("Y-m-d");
        }

        $stats_traffic = StatsRecent::where('site_id', $site->id);
        if ($start == $end)
            $stats_traffic = $stats_traffic->where('day', $start);
        else
            $stats_traffic = $stats_traffic->whereBetween('day', [$start, $end]);

        $stats_traffic = $stats_traffic->orderBy('id')->get();

        // COUNTRIES
        $countries_temp = [];
        foreach ($stats_traffic as $days_data) {
            $countries_array = json_decode($days_data->countries);
            array_push($countries_temp, $countries_array);
        }

        $countries_temp2 = array();
        foreach ($countries_temp as $row_array) {
            if ($row_array ?? null) {
                foreach ($row_array as $row) {
                    $country_name = $row->country;
                    $country_code = $row->code;
                    if (!isset($countries_temp2[$country_name])) {
                        $countries_temp2[$country_name]['country'] = $country_name;
                        $countries_temp2[$country_name]['country_code'] = $country_code;
                        $countries_temp2[$country_name]['counter'] = 0;
                    }
                    $countries_temp2[$country_name]['counter'] += $row->counter;
                }
            }
        }
        $countries = array_values($countries_temp2);
        array_multisort(array_column($countries, 'counter'), SORT_DESC, $countries);


        // DEVICES
        $devices_temp = [];
        foreach ($stats_traffic as $days_data) {
            $devices_array = json_decode($days_data->devices);
            array_push($devices_temp, $devices_array);
        }

        $devices_temp2 = array();
        foreach ($devices_temp as $row_array) {
            if ($row_array ?? null) {
                foreach ($row_array as $row) {
                    $device_type = $row->type;
                    if (!isset($devices_temp2[$device_type])) {
                        $devices_temp2[$device_type]['type'] = $device_type;
                        $devices_temp2[$device_type]['counter'] = 0;
                    }
                    $devices_temp2[$device_type]['counter'] += $row->counter;
                }
            }
        }
        $devices = array_values($devices_temp2);
        array_multisort(array_column($devices, 'counter'), SORT_DESC, $devices);



        // REFERRERS
        $referrers_temp = [];
        foreach ($stats_traffic as $days_data) {
            $referrers_array = json_decode($days_data->referrers);
            array_push($referrers_temp, $referrers_array);
        }

        $referrers_temp2 = array();
        foreach ($referrers_temp as $row_array) {
            if ($row_array ?? null) {
                foreach ($row_array as $row) {
                    $host = $row->host;
                    if (!isset($referrers_temp2[$host])) {
                        $referrers_temp2[$host]['host'] = $host;
                        $referrers_temp2[$host]['counter'] = 0;
                    }
                    $referrers_temp2[$host]['counter'] += $row->counter;
                }
            }
        }
        $referrers = array_values($referrers_temp2);
        array_multisort(array_column($referrers, 'counter'), SORT_DESC, $referrers);


        // TOP PAGES
        $top_pages_temp = [];
        foreach ($stats_traffic as $days_data) {
            $top_pages_array = json_decode($days_data->top_pages);
            array_push($top_pages_temp, $top_pages_array);
        }

        $top_pages_temp2 = array();
        foreach ($top_pages_temp as $row_array) {
            if ($row_array ?? null) {
                foreach ($row_array as $row) {
                    $url = $row->url;
                    $title = $row->title;
                    $page_hash = $row->page_hash;
                    if (!isset($top_pages_temp2[$url])) {
                        $top_pages_temp2[$url]['url'] = $url;
                        $top_pages_temp2[$url]['title'] = $title;
                        $top_pages_temp2[$url]['page_hash'] = $page_hash;
                        $top_pages_temp2[$url]['counter'] = 0;
                    }
                    $top_pages_temp2[$url]['counter'] += $row->counter;
                }
            }
        }
        $top_pages = array_values($top_pages_temp2);
        array_multisort(array_column($top_pages, 'counter'), SORT_DESC, $top_pages);


        return view('account.index', [
            'view_file' => 'stats.reports',
            'active_menu' => 'reports',
            'site' => $site,
            'stats_traffic' => $stats_traffic,
            'countries' => $countries ?? null, // for countries stats
            'countries_list' => $countries_list ?? null, // for countries stats
            'devices' => $devices ?? null, // for devices stats
            'avg_time_items' => $avg_time_items ?? null, // for average time stats
            'referrers' => $referrers ?? null, // for referrers stats
            'top_pages' => $top_pages ?? null, // for top pages stats

            'range_start' => $start,
            'range_end' => $end,

            'date_today' => date('Y-m-d'),
            'date_yesterday' => date('Y-m-d', strtotime("-1 days")),
            'date_7_days_ago' => date('Y-m-d', strtotime("-7 days")),
            'date_30_days_ago' => date('Y-m-d', strtotime("-30 days")),
        ]);
    }
}
