<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        if ($this->resource->relationLoaded('bookings')) {
            $data['bookings'] = BookingResource::collection($this->bookings);
        }

        if ($this->resource->relationLoaded('journals')) {
            $data['journals'] = JournalResource::collection($this->journals);
        }

        return $data;
    }

}
