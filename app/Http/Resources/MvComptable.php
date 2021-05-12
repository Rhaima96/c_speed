<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MvComptable extends JsonResource
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
            'num_piece'=>$this->num_piece,
            'ref'=>$this->ref,
            'code'=>$this->code,
            'libelle'=>$this->libelle,
            'm_debit'=>$this->m_debit,
            'm_credit'=>$this->m_credit,
            'tva'=>$this->tva,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
            "rec"=> $this->rec
        ];
    }
}
