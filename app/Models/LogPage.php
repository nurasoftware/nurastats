<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPage extends Model
{

    protected $table = 'log_pages';

    protected $fillable = [
        'site_id',
        'hash',
        'domain',
        'page',
        'title',
        'views',        
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }
}
