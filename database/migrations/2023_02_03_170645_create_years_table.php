<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('l_years', function (Blueprint $table) {
            $table->id(); //Id
            $table->timestamps(); //Thoi gian
            $table->string('course'); //Năm tuyển sinh Có
            $table->string('president'); //Chủ tịch hội đồng Có
            $table->string('file_council'); //File hội dồng tuyển sinh
            $table->string('chief_amanuensis'); //Trưởng ban thư ký
            $table->string('file_amanuensis'); // File ban thư ký

            $table->string('regulation'); //Quy chế Bộ Giáo dục
            $table->string('file_regulation'); //File quy chế
            $table->string('regulation2'); // Quy chế Trường
            $table->string('file_regulation2'); //File quy chế

            $table->string('plan1'); // Kế hoạch tuyển sinh Bộ
            $table->string('file_plan1'); //File kế hoạch
            $table->string('plan2'); // Kế hoạch tuyển sinh trường
            $table->string('file_plan2'); //file kế hoạch

            $table->string('note'); // Ghi chú
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('l_years');
    }
}
