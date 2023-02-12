<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'status'        => $this->status,
            'started_at'    => $this->started_at,
            'finished_at'   => $this->finished_at,
            'team_id'       => $this->team_id,
            'creator_id'    => $this->creator_id,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'creator'       => new UserResource($this->creator),
            'team'          => new TeamResource($this->team),
        ];
    }
}
