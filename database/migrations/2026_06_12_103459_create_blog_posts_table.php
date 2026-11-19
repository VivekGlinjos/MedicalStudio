<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('General');
            $table->text('excerpt');
            $table->longText('content');
            $table->string('author')->default('Medical Studio Team');
            $table->string('image')->nullable();
            $table->string('tags')->nullable();
            $table->text('seo_text')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
