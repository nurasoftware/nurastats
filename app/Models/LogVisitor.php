<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LogVisitor extends Model
{

    protected $table = 'log_visitors';

    protected $fillable = [
        'site_id',
        'hash',
        'ip',
        'device_type',
        'platform_family',
        'platform_name',
        'platform_version',
        'browser_family',
        'browser_name',
        'browser_version',
        'device_family',
        'device_model',
        'screen_size',
        'count_visits',
        'geo_cc',
        'geo_country',
        'geo_region',
        'geo_region_name',
        'geo_city',
        'geo_isp',
        'geo_lat',
        'geo_long',
    ];

    protected $appends = ['last_5_sessions', 'time_diff_human'];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function sessions()
    {
        return $this->hasMany(LogSession::class, 'visitor_id', 'id');
    }

    public function getLast5SessionsAttribute()
    {
        return $this->sessions()->take(3)->get();
    }


    public function getTimeDiffHumanAttribute()
    {
        $created_at = LogVisitor::where('id', $this->id)->value('created_at');
        $dt = Carbon::parse($created_at);
        $dt->locale('ro');

        return $dt->diffForHumans();
    }
}
