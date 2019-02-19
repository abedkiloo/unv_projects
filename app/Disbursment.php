<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disbursment extends Model
{
    protected $table = 'tbl_disbursments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'amount',
        'phase_id',
        'project_id',
    ];

    public function phase_id()
    {
        return $this->hasMany('App\PhaseOfDisbursment', 'id', 'id');
    }

    public function projects()
    {
        return $this->hasMany('App\Projects', 'id', 'project_id');
    }

}
