<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

        DB::table('kino_countries')->insert([
            ['slug' => 'au', 'name' => 'Австралия'],
            ['slug' => 'ar', 'name' => 'Аргентина'],
            ['slug' => 'am', 'name' => 'Армения'],
            ['slug' => 'by', 'name' => 'Беларусь'],
            ['slug' => 'be', 'name' => 'Бельгия'],
            ['slug' => 'br', 'name' => 'Бразилия'],
            ['slug' => 'gb', 'name' => 'Великобритания'],
            ['slug' => 'hu', 'name' => 'Венгрия'],
            ['slug' => 'de', 'name' => 'Германия'],
            ['slug' => 'hk', 'name' => 'Гонконг'],
            ['slug' => 'dk', 'name' => 'Дания'],
            ['slug' => 'in', 'name' => 'Индия'],
            ['slug' => 'ie', 'name' => 'Ирландия'],
            ['slug' => 'es', 'name' => 'Испания'],
            ['slug' => 'it', 'name' => 'Италия'],
            ['slug' => 'kz', 'name' => 'Казахстан'],
            ['slug' => 'ca', 'name' => 'Канада'],
            ['slug' => 'cn', 'name' => 'Китай'],
            ['slug' => 'co', 'name' => 'Колумбия'],
            ['slug' => 'mx', 'name' => 'Мексика'],
            ['slug' => 'nl', 'name' => 'Нидерланды'],
            ['slug' => 'nz', 'name' => 'Новая Зеландия'],
            ['slug' => 'no', 'name' => 'Норвегия'],
            ['slug' => 'pl', 'name' => 'Польша'],
            ['slug' => 'ru', 'name' => 'Россия'],
            ['slug' => 'su', 'name' => 'СССР'],
            ['slug' => 'us', 'name' => 'США'],
            ['slug' => 'th', 'name' => 'Таиланд'],
            ['slug' => 'tr', 'name' => 'Турция'],
            ['slug' => 'fi', 'name' => 'Финляндия'],
            ['slug' => 'fr', 'name' => 'Франция'],
            ['slug' => 'ch', 'name' => 'Швейцария'],
            ['slug' => 'se', 'name' => 'Швеция'],
            ['slug' => 'za', 'name' => 'ЮАР'],
            ['slug' => 'kr', 'name' => 'Южная Корея'],
            ['slug' => 'jp', 'name' => 'Япония'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kino_countries');
    }
};
