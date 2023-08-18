<?php

namespace App\Models;

use App\Http\Enums\ShopStatus;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Shops
 *
 * @property int $id
 * @property string $address Shop address
 * @property string $schedule Work schedule
 * @property string $latitude Latitude of the shop
 * @property string $longitude Longitude of the shop
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $merchant_id Belong mechant
 * @property int $status Status: 1-Active, 2-Inactive
 * @method static Builder|Shops newModelQuery()
 * @method static Builder|Shops newQuery()
 * @method static Builder|Shops query()
 * @method static Builder|Shops whereAddress($value)
 * @method static Builder|Shops whereCreatedAt($value)
 * @method static Builder|Shops whereId($value)
 * @method static Builder|Shops whereLatitude($value)
 * @method static Builder|Shops whereLongitude($value)
 * @method static Builder|Shops whereMerchantId($value)
 * @method static Builder|Shops whereSchedule($value)
 * @method static Builder|Shops whereStatus($value)
 * @method static Builder|Shops whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Shops extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Convert/Cast response format
    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
        'status' => ShopStatus::class
    ];


    /**
     * Calculate distance
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $precision
     * @return float
     */
    public function calculateDistance(float $latitude,float $longitude,int $precision = 3): float
    {
        $latDiff  = deg2rad($latitude - $this->latitude);
        $longDiff = deg2rad($longitude - $this->longitude);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($this->latitude)) * cos(deg2rad($latitude)) *
             sin($longDiff / 2) * sin($longDiff / 2);

        return round((12742 * atan2(sqrt($a), sqrt(1 - $a))),$precision);
    }
}
