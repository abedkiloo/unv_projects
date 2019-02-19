<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReadinessType extends Model
{
    protected $table = 'tbl_readiness_type';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'readiness_type_name', 'id'
    ];


    public function ready_projects()
    {
        return $this->hasMany('App\Projects', 'readiness_id', 'id');
    }



}
