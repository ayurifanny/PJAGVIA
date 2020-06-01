<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropMeetingIdFromReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            //
            $table->dropForeign('reports_meeting_id_foreign');
            $table->dropColumn('meeting_id');
        });

        Schema::table('meetings', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('report_id')->after('id');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('meeting_id')->after('id');
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');

        });

        Schema::table('meetings', function (Blueprint $table) {
            //
            $table->dropForeign('meetings_report_id_foreign');
            $table->dropColumn('report_id');
        });
    }
}
