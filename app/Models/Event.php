<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{

    protected $table = 'events';

    protected $fillable = ['site_id', 'code', 'created_by_user_id', 'type', 'label', 'slug', 'description', 'active'];
    

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }

}
