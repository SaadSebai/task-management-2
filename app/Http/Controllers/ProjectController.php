<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\IndexProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  IndexProjectRequest  $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexProjectRequest $request): AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::query()
                ->filter($request->safe()->filters ?? [])
                ->order(
                    sort_attribute: $request->safe()->sort_attribute ?? null,
                    sort_order:     $request->safe()->sort_order ?? null
                )
                ->with('creator', 'team')
                ->paginate()
                ->withQueryString()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProjectRequest  $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = Project::create(
            $request->validated() + ['creator_id' => auth()->id()]
        );

        return response()->json([
            'message'   => __('User has been created successfully'),
            'team'      => new ProjectResource($project->load('creator', 'team'))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Project  $project
     * @return ProjectResource
     */
    public function show(Project $project): ProjectResource
    {
        return new ProjectResource(
            $project->load('creator', 'team')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProjectRequest  $request
     * @param  Project  $project
     * @return JsonResponse
     */
    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $project->update($request->validated());

        return response()->json([
            'message'   => __('User has been updated successfully'),
            'team'      => new ProjectResource($project->load('creator', 'team'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @return JsonResponse
     */
    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json([
            'message'   => __('User has been deleted successfully'),
            'team'      => new ProjectResource($project)
        ]);
    }
}
