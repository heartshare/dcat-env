<?php


namespace Dcat\Admin\Satan\Env\Models;


class Env extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'satan_env';
    protected $dateFormat ='U';
    protected $fillable = [
        'id','env_key','env_value','created_at','updated_at'
    ];
    public $timestamps = true;
}
