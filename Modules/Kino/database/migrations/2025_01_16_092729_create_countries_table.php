<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Kino\Database\Seeders\CountryRealSeeder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kino_countries', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent()->comment('Добавлена');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('Отредактирована');

            $table->boolean('is_active')->index()->default(1)->comment('Активна');
            $table->integer('order')->default(999)->comment('Порядок');
            $table->string('slug')->index()->unique()->comment('Slug');
            $table->string('name')->index()->comment('Название');
        });

        $seeder = new CountryRealSeeder;
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kino_countries');
    }
};
