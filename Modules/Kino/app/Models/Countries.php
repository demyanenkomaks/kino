<?php

namespace Modules\Kino\Models;

use App\Traits\HasActive;
use Illuminate\Database\Eloquent\Model;

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
class Countries extends Model
{
    use HasActive;

    protected $table = 'kino_countries';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['is_active', 'order', 'slug', 'name'];
}
