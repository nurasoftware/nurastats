<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatsMain extends Model
{

    protected $table = 'stats_main';

    protected $fillable = ['site_id', 'hash', 'visitors_h', 'visitors_d', 'visitors_w', 'visitors_m', 'last', 'scroll_percent'];
    
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }
    
}
