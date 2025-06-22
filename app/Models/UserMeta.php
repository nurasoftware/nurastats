<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class UserMeta extends Model
{
    use HasFactory;
    
    protected $table = 'user_meta';

    protected $fillable = ['user_id', 'name', 'value'];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function metaData()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'id');
    }

    public function get_meta_attribute()
    {
        return $this->metaData()->get()->pluck('value', 'name')->toArray();
    }

    public static function get_meta($user_id, $name)
    {
        $value = UserMeta::where('name', $name)->where('user_id', $user_id)->value('value');

        return $value;
    }

    // Get meta value for myself (logged user)
    public static function my($name)
    {
        if(! (Auth::user())) return null;

        $value = UserMeta::where('name', $name)->where('user_id', Auth::user()->id)->value('value');

        return $value;
    }

    public static function add_meta($user_id, $name, $value)
    {
        UserMeta::updateOrInsert(
            ['name' => $name, 'user_id' => $user_id],
            ['value' => $value]
        );
    }
}
