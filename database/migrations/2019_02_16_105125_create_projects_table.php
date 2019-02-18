<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_ref');
            $table->string('project_title');
            $table->string('date_of_gcf')->nullable();
            $table->string('start_date');
            $table->string('implementing_office');
            $table->string('duration');
            $table->string('amount');
            $table->string('end_date');
            $table->string('country_id')->nullable();
            $table->string('disbursement_id')->nullable();
            $table->string('readiness_id')->nullable();
            $table->string('readiness_or_nap')->nullable();
            $table->string('status_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_projects');
    }
}
