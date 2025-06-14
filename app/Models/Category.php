<?php

declare(strict_types=1);

namespace App\Models;

use App\Policies\CategoryPolicy;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UsePolicy(CategoryPolicy::class)]
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'user_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(related: Category::class, foreignKey: 'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id');
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(related: Category::class, foreignKey: 'parent_id');
    }
}
