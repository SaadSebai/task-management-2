<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teams\AddMemberRequest;
use App\Http\Requests\Teams\IndexTeamRequest;
use App\Models\Team;
use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Requests\Teams\UpdateTeamRequest;
use App\Http\Resources\TeamResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexTeamRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexTeamRequest $request): AnonymousResourceCollection
    {
        return TeamResource::collection(
            Team::query()
                ->filter($request->safe()->filters ?? [])
                ->order(
                    sort_attribute: $request->safe()->sort_attribute ?? null,
                    sort_order:     $request->safe()->sort_order ?? null
                )
                ->with('creator')
                ->paginate()
                ->withQueryString()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTeamRequest  $request
     * @return JsonResponse
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        $team = Team::create(
            $request->validated() + ['creator_id' => auth()->id()]
        );

        return response()->json([
            'message'   => __('User has been created successfully'),
            'team'      => new TeamResource($team->load('creator'))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Team  $team
     * @return TeamResource
     */
    public function show(Team $team): TeamResource
    {
        return new TeamResource(
            $team->load('creator')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTeamRequest  $request
     * @param  Team  $team
     * @return JsonResponse
     */
    public function update(UpdateTeamRequest $request, Team $team): JsonResponse
    {
        $team->update($request->validated());

        return response()->json([
            'message'   => __('User has been updated successfully'),
            'team'      => new TeamResource($team->load('creator'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Team  $team
     * @return JsonResponse
     */
    public function destroy(Team $team): JsonResponse
    {
        $team->delete();

        return response()->json([
            'message'   => __('User has been deleted successfully'),
            'team'      => new TeamResource($team)
        ]);
    }

    /**
     * Add New Member to team.
     *
     * @param  AddMemberRequest  $request
     * @param  Team  $team
     * @return JsonResponse
     */
    public function addMember(AddMemberRequest $request, Team $team): JsonResponse
    {
        $team->users()->attach($request->safe()->user_id);

        return response()->json([
            'message' => __('User has been added to the Team'),
        ]);
    }
}
