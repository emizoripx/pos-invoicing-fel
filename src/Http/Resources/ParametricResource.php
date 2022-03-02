<?php

namespace EmizorIpx\PosInvoicingFel\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParametricResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion
        ];
    }
}
