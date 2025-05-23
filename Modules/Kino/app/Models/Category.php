<?php

namespace Modules\Kino\Models;

use App\Traits\HasActive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Kino\Database\Factories\CategoryFactory;

/**
 * Класс модели для таблицы "kino_categories".
 *
 * @property int $id
 * @property string $created_at Добавлена
 * @property string $updated_at Отредактирована
 * @property bool $is_active Активна
 * @property int $order Порядок
 * @property string $slug Slug
 * @property string $name Название
 * @property string|null $title Заголовок
 * @property string|null $description Описание
 * @property Category $mainCategories Главные категории
 * @property Category $categories Категории
 */
class Category extends Model
{
    use HasActive;
    use HasFactory;

    protected $table = 'kino_categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['is_active', 'order', 'slug', 'name', 'title', 'description'];

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    /**
     * @return BelongsToMany <Category, $this>
     */
    public function mainCategories(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'kino_category_sub', 'sub_category_id', 'category_id')
            ->withPivot('order');
    }

    /**
     * @return BelongsToMany <Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'kino_category_sub', 'category_id', 'sub_category_id')
            ->withPivot(['order', 'title', 'description'])
            ->orderBy('kino_category_sub.order');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
