<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'priority' => $this->priority,
            'active' => $this->active,
            'published_at' => $this->published_at,
            'expires_at' => $this->expires_at,
            'image_path' => $this->image_path,
            'image_url' => $this->image_path ? asset("storage/" . $this->image_path) : null,
            'creator' => new UserResource($this->whenLoaded('creator')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
