<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'user_id',
    ];

    public function category(): BelongsTo
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
