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
            $table->string('date_of_gcf');
            $table->string('start_date');
            $table->string('duration');
            $table->string('end_date');
            $table->string('disbursement_id');
            $table->string('readiness_id');
            $table->string('readiness_or_nap');
            $table->string('status_id');
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
