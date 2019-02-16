<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhaseOfDisbursment extends Model
{
    protected $table = 'tbl_phase_of_disbursments';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phase_name', 'id'
    ];

    public function disburse_name()
    {
        return $this->hasOne('App\Disbursment', 'tbl_disbursments.id', 'tbl_phase_of_disbursments.id');
    }

}
