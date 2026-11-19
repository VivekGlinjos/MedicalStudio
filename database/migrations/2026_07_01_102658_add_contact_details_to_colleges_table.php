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
            $table->string('dean_email')->nullable()->after('remarks');
            $table->string('dean_contact')->nullable()->after('dean_email');
            $table->string('principal_email')->nullable()->after('dean_contact');
            $table->string('principal_contact')->nullable()->after('principal_email');
            $table->string('nodal_email')->nullable()->after('principal_contact');
            $table->string('nodal_contact')->nullable()->after('nodal_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropColumn([
                'dean_email', 'dean_contact',
                'principal_email', 'principal_contact',
                'nodal_email', 'nodal_contact'
            ]);
        });
    }
};
