<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tasks\IndexTaskRequest;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  IndexTaskRequest  $request
     * @param  Project  $project
     * @return AnonymousResourceCollection
     */
    public function index(IndexTaskRequest $request, Project $project): AnonymousResourceCollection
    {
        return TaskResource::collection(
            $project->tasks()
                ->filter($request->safe()->filters ?? [])
                ->order(
                    sort_attribute: $request->safe()->sort_attribute ?? null,
                    sort_order:     $request->safe()->sort_order ?? null
                )
                ->with('creator', 'project', 'user')
                ->paginate()
                ->withQueryString()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTaskRequest  $request
     * @param  Project  $project
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $task = $project->tasks()
                        ->create(
                            $request->validated() + ['creator_id' => auth()->id()]
                        );

        return response()->json([
            'message'   => __('User has been created successfully'),
            'team'      => new TaskResource($task->load('creator', 'project', 'user'))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Project  $project
     * @param  Task  $task
     * @return TaskResource
     */
    public function show(Project $project, Task $task): TaskResource
    {
        return new TaskResource(
            $task->load('creator', 'project', 'user')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTaskRequest  $request
     * @param  Project  $project
     * @param  Task  $task
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task): JsonResponse
    {
        $task->update($request->validated());

        return response()->json([
            'message'   => __('User has been updated successfully'),
            'team'      => new TaskResource($task->load('creator', 'project', 'user'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $project
     * @param  Task  $task
     * @return JsonResponse
     */
    public function destroy(Project $project, Task $task): JsonResponse
    {
        $task->delete();

        return response()->json([
            'message'   => __('User has been deleted successfully'),
            'team'      => new TaskResource($task)
        ]);
    }
}
