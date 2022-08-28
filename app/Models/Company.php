<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'email',
        'phone'
    ];

    /**
     * @return HasMany
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'client_id');
    }
}
