<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
              'userId'=>$this->id,
               'userName' =>$this->name,
               'mail'=>$this->email,
               'createdAt'=>date('Y-m-d',strtotime($this->created_at)),
               'isAdmin' =>$this->when($this->id === 1,'1','0')
        ];
    }
}
