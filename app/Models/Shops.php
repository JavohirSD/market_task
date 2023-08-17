<?php

namespace App\Models;

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
}