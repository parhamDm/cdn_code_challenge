<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    public $timestamps =false;
    protected $table ='codes';
    protected $primaryKey ='id';

    public function winners()
    {
        return $this->hasMany('App\Winner');
    }
}
