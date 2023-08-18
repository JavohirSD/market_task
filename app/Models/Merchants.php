<?php

namespace App\Models;

use App\Http\Enums\MerchantStatus;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Merchants
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $balance Merchant balance
 * @property string $name Merchant name
 * @property int $status Status: 1-Active, 2-Inactive
 * @property int $user_id Belongs to user
 * @method static Builder|Merchants newModelQuery()
 * @method static Builder|Merchants newQuery()
 * @method static Builder|Merchants query()
 * @method static Builder|Merchants whereBalance($value)
 * @method static Builder|Merchants whereCreatedAt($value)
 * @method static Builder|Merchants whereId($value)
 * @method static Builder|Merchants whereName($value)
 * @method static Builder|Merchants whereStatus($value)
 * @method static Builder|Merchants whereUpdatedAt($value)
 * @method static Builder|Merchants whereUserId($value)
 * @mixin Eloquent
 */
class Merchants extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Convert/Cast response format
    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'status' => MerchantStatus::class
    ];


    public function shops(): HasMany
    {
        return $this->hasMany(Shops::class);
    }
}
