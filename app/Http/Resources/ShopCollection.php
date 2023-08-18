<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class ShopCollection extends ResourceCollection
{
    private array $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total'        => $resource->total(),
            'count'        => $resource->count(), // count of items in current page.
            'per_page'     => $resource->perPage(), // given count of items per page
            'current_page' => $resource->currentPage(),
            'total_pages'  => $resource->lastPage()
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request): array|JsonSerializable|Arrayable
    {
        return [
            'shops'  => $this->collection,
            'pagination' => $this->pagination,
        ];
    }
}
