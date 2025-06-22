<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LogSession extends Model
{

    protected $table = 'log_session';

    protected $fillable = ['hash', 'visitor_id', 'site_id', 'page_id', 'referrer', 'referrer_host', 'first', 'last', 'scroll_percent', 'seconds_min', 'event_id', 'created_at'];

    public $timestamps = false;

    protected $appends = ['count_sessions', 'time_diff_human'];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function visitor()
    {
        return $this->belongsTo(LogVisitor::class, 'visitor_id', 'id');
    }

    public function page()
    {
        return $this->belongsTo(LogPage::class, 'page_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }


    public function getCountSessionsAttribute()
    {        
        $count_sessions = LogSession::where('page_id', $this->page_id)->count();
        return $count_sessions;
    }

    public function getTimeDiffHumanAttribute()
    {
        $created_at = LogSession::where('id', $this->id)->value('created_at');
        $dt = Carbon::parse($created_at);
        $dt->locale('ro');

        return $dt->diffForHumans();
    }
}
