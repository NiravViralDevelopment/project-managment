<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Circle extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = ['name', 'zone_id'];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function divisions(): HasMany
    {
        return $this->hasMany(Division::class);
    }
}
