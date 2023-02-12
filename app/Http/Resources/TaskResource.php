<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'name'          => $this->name,
            'description'   => $this->description,
            'status'        => $this->status,
            'started_at'    => $this->strated_at,
            'finished_at'   => $this->finished_at,
            'project_id'    => $this->project_id,
            'user_id'       => $this->user_id,
            'creator_id'    => $this->creator_id,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'project'       => new ProjectResource($this->project),
            'user'          => new UserResource($this->user),
            'creator'       => new UserResource($this->creator),
        ];
    }
}
