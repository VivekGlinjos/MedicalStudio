<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id('college_id');
            $table->unsignedBigInteger('state_id');
            $table->tinyInteger('college_type')->default(0)->comment('Govt=0,Private=1');
            $table->string('college_name');
            $table->string('college_image')->nullable();
            $table->string('college_banner')->nullable();
            $table->string('place')->nullable();
            $table->text('about_us')->nullable();
            $table->longText('college_description')->nullable();
            $table->string('courses')->nullable();
            $table->string('year_of_inspection')->nullable();
            $table->text('seo_text')->nullable();
            $table->tinyInteger('is_active')->default(0)->comment('Active=0,InActive=1');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
