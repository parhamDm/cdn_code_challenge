<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ResponseCollection extends ResourceCollection
{
    protected $status_code;
    protected $status_msg;

    public function __construct($resource,string $status_code,string $status_msg)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->status_code = $status_code;
        $this->status_msg = $status_msg;
    }
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
    public function with($request)
    {
        return [
            'status_code' => $this->status_code,
            'status_msg' => $this->status_msg,
        ];
    }

}
