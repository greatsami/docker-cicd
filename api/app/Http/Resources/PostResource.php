<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property string $title
 * @property string $headline
 * @property string $content
 * @property boolean $is_published
 * @property Carbon $publish_at
 */
class PostResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'headline' => $this->headline,
            'content' => $this->content,
            'is_published' => $this->is_published,
            'publish_at' => $this->publish_at,
            'author' => UserResource::make($this->whenLoaded('author')),
        ];
    }
}
