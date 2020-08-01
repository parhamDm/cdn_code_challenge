<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed status_code
 * @property mixed status_msg
 */
class Response extends JsonResource
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
            'status_code' => $this->status_code,
            'status_msg' => $this->status_msg,
        ];
    }
}
