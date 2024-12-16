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
        Schema::create('kino_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamp('created_at')->useCurrent()->comment('Добавлена');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate()->comment('Отредактирована');

            $table->boolean('is_active')->index()->default(0)->comment('Активна');
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
            $table->string('title')->nullable()->comment('Заголовок');
            $table->text('description')->nullable()->comment('Описание');
        });

        // Главные категории
        DB::table('kino_categories')->insert([
            ['id' => 1, 'is_active' => 1, 'slug' => 'movies', 'name' => 'Фильмы', 'title' => 'Фильмы смотреть онлайн', 'description' => 'Фильмы — это искусство, способное перенести зрителя в миры, полные эмоций и приключений.'],
            ['id' => 2, 'is_active' => 1, 'slug' => 'series', 'name' => 'Сериалы', 'title' => 'Сериалы смотреть онлайн', 'description' => 'Сериалы стали неотъемлемой частью современного развлекательного контента, привлекая зрителей своим разнообразием и глубиной сюжета.'],
            ['id' => 3, 'is_active' => 1, 'slug' => 'animation', 'name' => 'Мультфильмы', 'title' => 'Мультфильмы смотреть онлайн', 'description' => 'Хотите смотреть мультфильмы онлайн бесплатно в хорошем качестве? Тогда милости просим на наш портал!'],
        ]);

        // Категории
        DB::table('kino_categories')->insert([

            // Категории для фильмов
            ['id' => 4, 'is_active' => 1, 'slug' => 'boeviki', 'name' => 'Боевики'],
            ['id' => 5, 'is_active' => 1, 'slug' => 'voennye', 'name' => 'Военные'],
            ['id' => 6, 'is_active' => 1, 'slug' => 'detective', 'name' => 'Детективы'],
            ['id' => 7, 'is_active' => 1, 'slug' => 'dlya-vsej-semi', 'name' => 'Семейные'],
            ['id' => 8, 'is_active' => 1, 'slug' => 'detskiy', 'name' => 'Для детей'],
            ['id' => 9, 'is_active' => 1, 'slug' => 'drama', 'name' => 'Драмы'],
            ['id' => 10, 'is_active' => 1, 'slug' => 'history', 'name' => 'Исторические'],
            ['id' => 11, 'is_active' => 1, 'slug' => 'comedy', 'name' => 'Комедии'],
            ['id' => 12, 'is_active' => 1, 'slug' => 'crime', 'name' => 'Криминал'],
            ['id' => 13, 'is_active' => 1, 'slug' => 'melodramy', 'name' => 'Мелодрамы'],
            ['id' => 14, 'is_active' => 1, 'slug' => 'adventures', 'name' => 'Приключения'],
            ['id' => 15, 'is_active' => 1, 'slug' => 'thriller', 'name' => 'Триллеры'],
            ['id' => 16, 'is_active' => 1, 'slug' => 'horror', 'name' => 'Ужасы'],
            ['id' => 17, 'is_active' => 1, 'slug' => 'fantastika', 'name' => 'Фантастика'],
            ['id' => 18, 'is_active' => 1, 'slug' => 'fentezi', 'name' => 'Фэнтези'],

            // Категории для сериалов отличные от фильмов
            ['id' => 19, 'is_active' => 1, 'slug' => 'anime', 'name' => 'Аниме'],
            ['id' => 20, 'is_active' => 1, 'slug' => 'doramy', 'name' => 'Дорамы'],
            ['id' => 21, 'is_active' => 1, 'slug' => 'latinoamerikanskie', 'name' => 'Латиноамериканские'],
            ['id' => 22, 'is_active' => 1, 'slug' => 'medicine', 'name' => 'Медицинские'],
            ['id' => 23, 'is_active' => 1, 'slug' => 'tr', 'name' => 'Турция'],

            // Категории для мультфильмов отличные от фильмов и сериалов
            ['id' => 24, 'is_active' => 1, 'slug' => 'vzroslye', 'name' => 'Для взрослых'],
            ['id' => 25, 'is_active' => 1, 'slug' => 'polnometrazhnye', 'name' => 'Полнометражные'],
            ['id' => 26, 'is_active' => 1, 'slug' => 'razvivayuschie', 'name' => 'Развивающие'],
            ['id' => 27, 'is_active' => 1, 'slug' => 'serialy', 'name' => 'Сериалы'],

        ]);

        // Подкатегории
        DB::table('kino_category_sub')->insert([
            // Фильмы
            ['category_id' => 1, 'sub_category_id' => 4, 'title' => '', 'description' => 'Фильмы жанра боевик - это не просто постоянная стрельба и игра в кошки мышки хорошего героя с плохим.'],
            ['category_id' => 1, 'sub_category_id' => 5, 'title' => 'Военные фильмы', 'description' => 'К сожалению, мировая история преподносит режиссерам все новые идеи для военных фильмов.'],
            ['category_id' => 1, 'sub_category_id' => 6, 'title' => 'Детективные фильмы', 'description' => 'Лучшие фильмы детективы привлекают зрителей кажущейся обыденностью сюжета и обстановки.'],
            ['category_id' => 1, 'sub_category_id' => 7, 'title' => 'Семейные фильмы', 'description' => 'Есть множество вариантов семейного досуга, и один из самых доступных – это совместныйпросмотр семейного кино.'],
            ['category_id' => 1, 'sub_category_id' => 8, 'title' => 'Детские фильмы', 'description' => 'Детское кино онлайн – отличная возможность познакомить ваших детей с лучшими советскими картинами и фильмами.'],
            ['category_id' => 1, 'sub_category_id' => 9, 'title' => '', 'description' => 'Вы не относитесь к числу поклонников фильмов с бесконечными драками, бешеными погонями и стрельбой, а предпочитаете по-настоящему душевное кино?'],
            ['category_id' => 1, 'sub_category_id' => 10, 'title' => 'Историческое кино', 'description' => 'Исторические фильмы – это правда или режиссерский вымысел?'],
            ['category_id' => 1, 'sub_category_id' => 11, 'title' => '', 'description' => 'Любишь смотреть онлайн комедии с участием Эдди Мёрфи, Джима Керри или Адама Сэндлера?'],
            ['category_id' => 1, 'sub_category_id' => 12, 'title' => 'Криминальные фильмы', 'description' => 'Запретная романтика криминального мира давно привлекает зрителей.'],
            ['category_id' => 1, 'sub_category_id' => 13, 'title' => '', 'description' => 'Хотите смотреть кино и испытывать при этом только самые глубокие и приятные чувства?'],
            ['category_id' => 1, 'sub_category_id' => 14, 'title' => 'Приключенческие фильмы', 'description' => 'Вы желаете погрузиться в мир необычайных и увлекательных приключений?'],
            ['category_id' => 1, 'sub_category_id' => 15, 'title' => '', 'description' => 'Хочется острых ощущений? Значит, пришла пора посмотреть леденящие кровь триллеры . '],
            ['category_id' => 1, 'sub_category_id' => 16, 'title' => '', 'description' => 'Пробегающий по коже мороз, острое желание забраться под одеяло с головой, перед этим проверив, крепко ли заперты двери, холодная дрожь по спине от любого шороха на кухне…'],
            ['category_id' => 1, 'sub_category_id' => 17, 'title' => 'Топ фантастических фильмов', 'description' => 'Приглашаем всех коллекционеров версий о конце света, интересующихся загробной жизнью, поклонников маленьких зеленых человечков.'],
            ['category_id' => 1, 'sub_category_id' => 18, 'title' => 'Фильмы фэнтези', 'description' => 'Необычное визуальное оформление, невероятные события, выдуманные миры, пронизанные магией и волшебством.'],

            // Сериалы
            ['category_id' => 2, 'sub_category_id' => 19, 'title' => 'Сериалы в жанре аниме', 'description' => ''],
            ['category_id' => 2, 'sub_category_id' => 4, 'title' => 'Сериалы-боевики', 'description' => 'Тысячи часов из жизни супергероев и простых людей, которые оказались в необычных обстоятельствах показаны в лучших сериалах боевиках, собранных на нашем кинотеатре.'],
            ['category_id' => 2, 'sub_category_id' => 5, 'title' => 'Сериалы про войну', 'description' => 'Если вы хотите хоть немного приблизиться к пониманию, что же такое война, советуем вам смотреть военные сериалы.'],
            ['category_id' => 2, 'sub_category_id' => 6, 'title' => 'Детективные сериалы', 'description' => 'Детективные сериалы – это не просто занятное времяпрепровождение, но еще и разминка для ума.'],
            ['category_id' => 2, 'sub_category_id' => 20, 'title' => '', 'description' => 'Чарующая Восточная Азия становится ближе и доступнее благодаря популярным дорамам, которые можно смотреть бесплатно в нашем онлайн-кинотеатре на русском языке и в хорошем качестве.'],
            ['category_id' => 2, 'sub_category_id' => 9, 'title' => 'Сериалы драмы смотреть онлайн', 'description' => 'Несмотря на многообразие существующих сегодня жанров, драма была и остается, пожалуй, безусловным лидером, не уступая в популярности комедиям и ужасам.'],
            ['category_id' => 2, 'sub_category_id' => 10, 'title' => 'Исторические сериалы онлайн', 'description' => 'Исторические сериалы – выбор любознательных зрителей.'],
            ['category_id' => 2, 'sub_category_id' => 11, 'title' => 'Комедийные сериалы', 'description' => 'Просмотр комедийных сериалов онлайн - это способ уйти от проблем в море позитива.'],
            ['category_id' => 2, 'sub_category_id' => 12, 'title' => 'Сериалы про криминал', 'description' => 'Самое интересное на свете – узнать, кто, за что и каким образом умертвил ближнего своего.'],
            ['category_id' => 2, 'sub_category_id' => 21, 'title' => 'Сериалы - Латиноамериканские', 'description' => ''],
            ['category_id' => 2, 'sub_category_id' => 22, 'title' => 'Медицинские сериалы', 'description' => 'Не только доктор Хаус – сериалы про врачей и медицину пользуются популярностью во всем мире и год за годом притягивают к экранам миллионы зрителей.'],
            ['category_id' => 2, 'sub_category_id' => 13, 'title' => 'Сериалы мелодрамы', 'description' => 'Мелодраматические сериалы пользуются у зрителей особой популярностью.'],
            ['category_id' => 2, 'sub_category_id' => 15, 'title' => 'Сериалы триллеры', 'description' => 'Готовы ли вы к тому, чтобы в вашу жизнь ворвалось что-то мистическое и неизведанное?'],
            ['category_id' => 2, 'sub_category_id' => 23, 'title' => 'Турецкие сериалы', 'description' => 'Предлагаем вашему вниманию подборку жизненных турецких сериалов.'],
            ['category_id' => 2, 'sub_category_id' => 17, 'title' => 'Фантастические сериалы', 'description' => 'Захватывающий сюжет, потрясающие спецэффекты, наделенные суперспособностями герои.'],

            // Мультфильмы
            ['category_id' => 3, 'sub_category_id' => 19, 'title' => '', 'description' => 'Аниме – совершенно особый и неповторимый жанр.'],
            ['category_id' => 3, 'sub_category_id' => 24, 'title' => 'Мультфильмы для взрослых', 'description' => 'Помните, как вы в детстве любили смотреть мультики? А теперь посмотрим на анимационных персонажей немного другими глазами…'],
            ['category_id' => 3, 'sub_category_id' => 7, 'title' => 'Семейные мультфильмы', 'description' => ''],
            ['category_id' => 3, 'sub_category_id' => 8, 'title' => 'Детские мультфильмы', 'description' => 'Мультики для детей нравятся всем без исключения маленьким непоседам.'],
            ['category_id' => 3, 'sub_category_id' => 11, 'title' => 'Комедийные мультфильмы', 'description' => ''],
            ['category_id' => 3, 'sub_category_id' => 25, 'title' => 'Полнометражные мультики', 'description' => 'Не стоит думать, что мультфильмы смотрят только дети – на самом деле анимационные истории уже давно привлекают внимание самых разных аудиторий.'],
            ['category_id' => 3, 'sub_category_id' => 14, 'title' => 'Приключенческие мультфильмы', 'description' => 'Кто сказал, что просмотр мультиков – привилегия счастливого детства? Совсем не так.'],
            ['category_id' => 3, 'sub_category_id' => 26, 'title' => 'Развивающие мультфильмы', 'description' => 'Какое детство без мультиков? Безусловно, дети от 2 лет просто обожают смотреть красочную анимацию всех сортов и готовы проводить у экрана много времени.'],
            ['category_id' => 3, 'sub_category_id' => 27, 'title' => 'Мультсериалы', 'description' => ''],
            ['category_id' => 3, 'sub_category_id' => 18, 'title' => 'Мультфильмы в жанре фэнтези', 'description' => ''],
        ]);
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
