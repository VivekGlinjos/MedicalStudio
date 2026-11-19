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
        Schema::table('colleges', function (Blueprint $table) {
            $table->string('extra_image_1')->nullable()->after('college_banner');
            $table->string('extra_image_2')->nullable()->after('extra_image_1');
            $table->string('extra_image_3')->nullable()->after('extra_image_2');
        });
    }

    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropColumn(['extra_image_1', 'extra_image_2', 'extra_image_3']);
        });
    }
};
