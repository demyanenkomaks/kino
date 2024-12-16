<?php

namespace Modules\Kino\Models;

use App\Traits\HasActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasActive;

    protected $table = 'kino_categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['is_active', 'order', 'slug', 'name', 'title', 'description'];

    /**
     * Главные категории
     * @return BelongsToMany
     */
    public function mainCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'kino_category_sub', 'sub_category_id', 'category_id')
            ->withPivot('order');
    }

    /**
     * Категории
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'kino_category_sub', 'category_id', 'sub_category_id')
            ->withPivot(['order', 'title', 'description'])
            ->orderBy('kino_category_sub.order');
    }
}
