<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('exam_settings', function (Blueprint $table) {
            $table->id();
            $table->string('exam_title');
            $table->string('syllabus_pdf_path');
            $table->dateTime('exam_date_time');
            $table->string('exam_center_location');
            $table->text('prize_details_json'); // Stores prize items like Tablet, TV, Dinner set
            $table->decimal('application_fee', 8, 2)->default(41.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_settings');
    }
}
