<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
      'client_name',
      'email',
      'site'
    ];

    /**
     * @return HasMany
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'company_id');
    }
}
