<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RestructureUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('uploads', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('type');
            $table->string('photo_edited')->nullable()->after('photo');
            // $table->renameColumn('approved', 'status');
            $table->json('drawings')->nullable()->after('photo_edited');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('uploads', function (Blueprint $table) {
            //

            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('type');
            // $table->renameColumn('status', 'approved');
            $table->dropColumn('photo_edited');
            $table->dropColumn('drawings');
        });
    }
}
