<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Enums\ShopStatus;
use App\Http\Requests\NearestShopRequest;
use App\Http\Requests\StoreMerchant;
use App\Http\Requests\StoreShopRequest;
use App\Http\Resources\MerchantCollection;
use App\Http\Resources\ShopCollection;
use App\Models\Merchants;
use App\Models\Shops;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ShopsController extends Controller
{
    /**
     * Get all shops
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $result = Cache::remember('all_shops_' . Auth::id(), 60, function () use ($request) {

            $merchant = Merchants::where('user_id', Auth::id())->first();

            if($merchant){
                return Shops::where('merchant_id', $merchant->id)
                            ->where('status', ShopStatus::ACTIVE)
                            ->paginate($request->input('per-page', 20));
            }

            return null;
        });

        return $result ? $this->success(new ShopCollection($result)) : $this->error(null,'Data not found');
    }


    /**
     * Create or get shop
     *
     * @param StoreShopRequest $request
     * @return JsonResponse
     */
    public function store(StoreShopRequest $request): JsonResponse
    {
        $merchant_id = Auth::user()?->merchant?->id;

        if($merchant_id === null){
            return $this->error(null,'Please create merchant first',Response::HTTP_BAD_REQUEST);
        }

        $merchant = Shops::create([
            'merchant_id'=> $merchant_id,
            'address'    => $request->input('address'),
            'schedule'   => $request->input('schedule'),
            'latitude'   => $request->input('latitude'),
            'longitude'  => $request->input('longitude'),
            'status'     => $request->input('status')
        ]);

        return $merchant ? $this->success($merchant,'Success',Response::HTTP_CREATED) : $this->error(null,'Error occurred');
    }


    /**
     * Update
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $shop = $this->findModel($id);

        if($shop === null){
            return $this->error('Shop not found');
        }

        if ($this->checkOwnership($shop) === false) {
            return $this->error(null, 'This is not your shop');
        }

        $shop->update([
            'address'   => $request->input('address'),
            'schedule'  => $request->input('schedule'),
            'latitude'  => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'status'    => $request->input('status')
        ]);

        Cache::forget('all_shops_' . Auth::id());
        return $this->success(Shops::find($id));
    }


    /**
     * Show single shop
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        if($shop = Shops::whereId($id)->where('status', ShopStatus::ACTIVE)->first()){
            return $this->success($shop);
        }

        return $this->error(null,'Not found', Response::HTTP_NOT_FOUND);
    }


    /**
     * Delete merchant
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        if($shop = $this->findModel($id)){

            if($this->checkOwnership($shop) === false){
                return $this->error(null, 'This is not your shop');
            }

            Cache::flush();
            return $this->success($shop->delete(),'Deleted');
        }

        return $this->error(null,'Not found', Response::HTTP_NOT_FOUND);
    }


    /**
     * Check ownership for the shop
     *
     * @param Shops $shop
     * @return bool
     */
    public function checkOwnership(Shops $shop): bool
    {
        return Auth::user()?->merchant?->id == $shop->merchant_id;
    }


    /**
     * Get shop model by id
     *
     * @param int $id
     * @return Model|Collection|Shops|array|null
     */
    public function findModel(int $id): Model|Collection|Shops|array|null
    {
        return Shops::find($id);
    }


    /**
     * Get shops by distance
     *
     * @param NearestShopRequest $request
     * @return JsonResponse
     */
    public function nearestShops(NearestShopRequest $request): JsonResponse
    {
        $shops = Merchants::find($request->input('merchant_id'))?->shops;

        if(count($shops) === 0){
            return $this->error(null,'No shops found for this merchant', Response::HTTP_NOT_FOUND);
        }

        foreach ($shops as $shop) {
            $shop->distance = $shop->getDistance($request->input('latitude'), $request->input('longitude')) . ' km';
        }

        return $this->success($shops->sortBy('distance'));
    }
}
