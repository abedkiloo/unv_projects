<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = "tbl_projects";


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_ref',
        'project_title',
        'date_of_gcf',
        'start_date',
        'duration',
        'end_date',
        'country_id',
        'disbursement_id',
        'readiness_id',
        'readiness_or_nap',
        'status_id',
    ];

    public function project_country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }

    public function project_disbursement()
    {
        return $this->hasOne('App\Disbursment', 'id', 'disbursement_id');
    }

    public function readiness_type()
    {
        return $this->hasOne('App\ReadinessType', 'id', 'readiness_id');
    }

    public function project_status()
    {
        return $this->hasOne('App\Status', 'id', 'status_id');
    }
}
