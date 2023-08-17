<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMerchant;
use App\Http\Resources\MerchantCollection;
use App\Models\Merchants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MerchantsController extends Controller
{
    public function index(Request $request)
    { //caache
         return Merchants::query()
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            })
            ->when($request->has('balance'), function ($query) use ($request) {
                $query->where('balance', $request->input('balance'));
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->paginate($request->input('per-page',20));
    }

    /**
     * Create or get merchant
     *
     * @param StoreMerchant $request
     * @return JsonResponse
     */
    public function store(StoreMerchant $request): JsonResponse
    {
        $merchant = Merchants::firstOrCreate(['user_id' => Auth::id()],
         [
            'name'    => $request->input('name'),
            'balance' => $request->integer('balance'),
            'status'  => $request->integer('status'),
        ]);

        return $this->success($merchant);
    }


    /**
     * Update
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $merchant = Merchants::where('user_id', Auth::id())->update(
            [
                'name'    => $request->input('name'),
                'balance' => $request->integer('balance'),
                'status'  => $request->integer('status'),
            ]);

        if($merchant){
            return $this->success(Merchants::where('user_id', Auth::id())->first());
        }

       return $this->error(null,'Error');
    }


    /**
     * Show single merchant
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        if($merchant = Merchants::find($id)){
            return $this->success($merchant);
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
        if(Merchants::find($id)?->delete()){
            return $this->success(null,'Deleted');
        }

        return $this->error(null,'Not found', Response::HTTP_NOT_FOUND);
    }
}
