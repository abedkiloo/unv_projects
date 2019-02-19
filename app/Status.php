<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = "tbl_status";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status_name', 'id'
    ];



    public function status_projects()
    {
        return $this->hasMany('App\Projects', 'status_id', 'id');
    }
}
