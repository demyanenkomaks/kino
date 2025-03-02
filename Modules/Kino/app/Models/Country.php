<?php

namespace Modules\Kino\Models;

use App\Traits\HasActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Kino\Database\Factories\CountryFactory;

/**
 * Класс модели для таблицы "kino_countries".
 *
 * @property int $id
 * @property string $created_at Добавлена
 * @property string $updated_at Отредактирована
 * @property bool $is_active Активна
 * @property int $order Порядок
 * @property string $slug Slug
 * @property string $name Название
 */
class Country extends Model
{
    use HasActive, HasFactory;

    protected $table = 'kino_countries';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['is_active', 'order', 'slug', 'name'];

    protected static function newFactory()
    {
        return CountryFactory::new();
    }
}
