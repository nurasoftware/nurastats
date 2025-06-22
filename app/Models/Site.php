<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{

    protected $table = 'sites';

    protected $fillable = ['user_id', 'code', 'url', 'label', 'active', 'clevada_status', 'timezone', 'allow_subdomains', 'favourite'];

    protected $appends = ['last_5_status_checks'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function status_checks()
    {
        return $this->hasMany(StatusChecker::class, 'site_id', 'id');
    }

    public function getLast5StatusChecksAttribute()
    {
        return $this->status_checks()->take(3)->get();
    }
}
