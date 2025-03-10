<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'client_id' => $this->client_id,
            'start'     => $this->start,
            'end'       => $this->end,
            'time_slot' => $this->time_slot,
            'notes'     => $this->notes,
        ];
    }
}
