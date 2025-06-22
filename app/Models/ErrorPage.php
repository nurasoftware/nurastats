<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorPage extends Model
{
    use HasFactory;    
    
    protected $table = 'error_pages';

    protected $fillable = ['site_id', 'path', 'referrer', 'data', 'counter'];
    
    public function site()
    {
        return $this->BelongsTo(Site::class, 'site_id', 'id');
    }            
}
