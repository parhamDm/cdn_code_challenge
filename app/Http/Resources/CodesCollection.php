<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CodesCollection extends ResponseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

}
