<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatsRecent extends Model
{

    protected $table = 'stats_recent';

    protected $fillable = ['site_id', 'day', 'visitors', 'views', 'average_time', 'devices', 'countries', 'referrers', 'top_pages'];
    
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }
    
}
