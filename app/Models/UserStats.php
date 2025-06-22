<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class UserStats extends Model
{
    use HasFactory;    
    
    protected $table = 'user_stats';

    protected $fillable = ['user_id', 'site_id', 'date', 'count_pageviews', 'count_events', 'count_actions'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function site()
    {
        return $this->hasMany(Site::class, 'site_id', 'id');
    }    
}
