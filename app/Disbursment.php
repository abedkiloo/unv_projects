<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disbursment extends Model
{
        protected $table = 'tbl_disbursments';

    public function phase_id()
    {
        return $this->hasOne('App\PhaseOfDisbursement', 'tbl_phase_of_disbursments.id', 'tbl_disbursments.id');
    }

}
