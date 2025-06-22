<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{

    protected $table = 'config';

    protected $fillable = ['name', 'value'];

    public $timestamps = false;

    public static function get_config($name)
    {
        $value = Config::where('name', $name)->value('value');

        return $value;
    }

    public static function add_config($name, $value)
    {
        Config::updateOrInsert(
            ['name' => $name],
            ['value' => $value]
        );
    }
}
