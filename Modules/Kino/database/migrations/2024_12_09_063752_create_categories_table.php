<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kino\Database\Seeders\CategoryRealSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kino_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent()->comment('Добавлена');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('Отредактирована');

            $table->boolean('is_active')->index()->default(1)->comment('Активна');
            $table->integer('order')->default(999)->comment('Порядок');
            $table->string('slug')->index()->unique()->comment('Slug');
            $table->string('name')->index()->comment('Название');
            $table->string('title')->nullable()->comment('Заголовок');
            $table->text('description')->nullable()->comment('Описание');
        });

        Schema::create('kino_category_sub', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->index()->comment('Главная категория')
                ->references('id')->on('kino_categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('sub_category_id')->index()->comment('Категория')
                ->references('id')->on('kino_categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['category_id', 'sub_category_id']);

            $table->unsignedInteger('order')->default(999);
            $table->string('title')->comment('Заголовок');
            $table->text('description')->nullable()->comment('Описание');
        });

        $seeder = new CategoryRealSeeder;
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kino_category_sub');
        Schema::dropIfExists('kino_categories');
    }
};
