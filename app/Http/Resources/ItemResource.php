<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->iditems,
            'name' => $this->item_name,
            'code' => $this->item_code,
            'price' => $this->item_price,
            'created_by' =>isset($this->user)?$this->user->name:'-',
            'time' => $this->updated_at->diffForHumans()
        ];
    }
}
