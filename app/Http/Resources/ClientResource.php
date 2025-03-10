<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    protected $withBookings = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);

        if ($this->withBookings) {
            $data['bookings'] = BookingResource::collection($this->bookings);
        }

        return $data;
    }

    public function withBookings()
    {
        $this->withBookings = true;
        return $this;
    }
}
