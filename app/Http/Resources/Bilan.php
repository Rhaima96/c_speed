<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Bilan extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'code'=>$this->code,
            'nom'=>$this->nom,
            'mv_id'=>$this->mv_id,
            'actif'=>$this->actif,
            'passif'=>$this->passif,
            'm_actif'=>$this->m_actif,
            "m_passif"=> $this->m_passif,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
