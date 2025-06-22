<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteUser extends Model
{

    protected $table = 'site_users';

    protected $fillable = ['site_id', 'user_id', 'role'];

}
