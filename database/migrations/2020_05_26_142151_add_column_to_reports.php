<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToReports extends Migration
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
            $table->unsignedBigInteger('meeting_id')->after('id');
            $table->foreign('meeting_id')->references('id')->on('meetings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('customer_name')->nullable();
            $table->string('customer_signature')->nullable();
            $table->unsignedBigInteger('host_id');
            $table->foreign('host_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('inspector_name')->nullable();
            $table->string('inspector_signature')->nullable();
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
            $table->dropForeign('reports_meeting_id_foreign');
            $table->dropColumn('meeting_id');
            $table->dropForeign('reports_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('customer_name');
            $table->dropColumn('customer_signature');
            $table->dropForeign('reports_host_id_foreign');
            $table->dropColumn('host_id');
            $table->dropColumn('inspector_name');
            $table->dropColumn('inspector_signature');

        });
    }
}
