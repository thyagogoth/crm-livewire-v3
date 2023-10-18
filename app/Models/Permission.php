<?php

namespace App\Models;

use App\Enums\Can;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['key'];

    //    protected $casts = [
    //        'key' => Can::class,
    //    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
