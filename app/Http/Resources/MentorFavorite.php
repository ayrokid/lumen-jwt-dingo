<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MentorFavorite extends Resource
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
            'id_mentor' => $this->id,
            'distance' => "0,7 Km",
            'photo' => !is_null($this->photo) ? $this->photo : 'default.png',
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'islike' => $this->islike,
            'unlike' => $this->unlike,
        ];
    }
}
