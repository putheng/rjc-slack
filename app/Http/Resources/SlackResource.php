<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SlackResource extends Resource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'slackid' => $this->slackid,
            'department' => $this->department,
            'position' => $this->position,
            'phone' => $this->phone,
            'card' => $this->card,
        ];
    }
}
