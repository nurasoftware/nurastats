<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusChecker extends Model
{

    protected $table = 'status_checker';

    protected $fillable = [
        'site_id',
        'code',
        'port',
        'url',
        'status_code',
        'response_time',
        'headers',
        'at',
    ];

    public $timestamps = false;

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }


    public static function website_stats($site_id)
    {
        $stats = array();

        $config_percent_green = 95;
        $config_percent_yellow = 50;
        $total_logs_online = 0;
        $total_logs = 0;
        $count_bars = 168; // 1 bar = 1 hour

        for ($bar = $count_bars - 1; $bar >= 0; $bar--) {

            // get bar logs (1 bar = 1 hour)
            $bar_start = $bar + 1;
            $bar_end = $bar;

            $date_start = date('Y-m-d H:i:s', strtotime("-$bar_start hour"));
            $date_end = date('Y-m-d H:i:s', strtotime("-$bar_end hour"));

            $results = StatusChecker::where('site_id', $site_id)->whereBetween('at', [$date_start, $date_end])->get();
            $count_logs = count($results);
            $total_logs = $total_logs + $count_logs;
            $count_offline = 0;
            $count_online = 0;
            $stat_uptime = 0;

            if ($count_logs == 0) {
                $color = 'grey'; // no checks
                $percent = 0;
                $stat_uptime = 0;
            } else {
                foreach ($results as $result) {
                    if ($result->status_code != 200) $count_offline = $count_offline + 1;
                    else $count_online = $count_online + 1;
                    $percent = $count_online / $count_logs * 100;
                    $percent = round($percent, 2);

                    if ($result->status_code == 200) $total_logs_online = $total_logs_online + 1;
                }

                $stat_uptime = $total_logs_online / $total_logs * 100;
                $stat_uptime = round($stat_uptime, 2);

                if ($count_online == 0) $color = 'red';
                else $color = StatusChecker::bar_color($stat_uptime);
            }

            $tooltip = date("F d, g:00 A", strtotime($date_end));
            $tooltip .= '<br>';
            if ($color == 'grey') $tooltip .= 'No data';
            else {
                if ($stat_uptime < 'yellow')
                    $tooltip_status = "<b class='inactive'>Offline</b>";
                elseif ($stat_uptime >= $config_percent_green)
                    $tooltip_status = "<b class='active'>Online</b>";
                else
                    $tooltip_status = "<b class='issues'>Issues</b>";

                $tooltip .= $tooltip_status;
            }

            $stats[] = array('start' => $date_start, 'end' => $date_end, 'color' => $color, 'percent' => $stat_uptime, 'stat_uptime' => $stat_uptime, 'tooltip' => $tooltip);
        }

        return $stats;
    }



    public static function bar_color($percent)
    {
        $config_percent_green = 95;
        $config_percent_yellow = 50;

        if ($percent >= $config_percent_green)
            $color = 'green';
        elseif ($percent >= $config_percent_yellow && $percent < $config_percent_green)
            $color = 'yellow';
        elseif ($percent > 0 && $percent < $config_percent_yellow)
            $color = 'red';
        else
            $color = 'grey';

        return $color;
    }
}
