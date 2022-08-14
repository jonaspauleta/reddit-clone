<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityStoreRequest;
use App\Http\Resources\CommunityPostResource;
use App\Models\Community;
use Inertia\Inertia;

class CommunityController extends Controller {
    public function index(): \Inertia\Response {
        $communities = Community::where('user_id', auth()->id())->paginate(5)->through(fn ($community) => [
            'id' => $community->id,
            'name' => $community->name,
            'slug' => $community->slug,
        ]);

        return Inertia::render('Communities/Index', compact('communities'));
    }

    public function create(): \Inertia\Response {
        return Inertia::render('Communities/Create');
    }

    public function store(CommunityStoreRequest $request): \Illuminate\Http\RedirectResponse {
        Community::create($request->validated() + ['user_id' => auth()->user()->id]);

        return redirect()->route('communities.index')->with('message', 'Community Created Successfully');
    }

    public function show(String $slug): \Inertia\Response {
        $community = Community::where('slug', $slug)->firstOrFail();
        $posts = CommunityPostResource::collection($community->posts()->with(['user', 'postVotes' => function ($query) {
            $query->where('user_id', auth()->id());
        }])->withCount('comments')->paginate(3));


        if ($community == null) {
            abort(404);
        }

        return Inertia::render('Communities/Show', [
            'community' => $community,
            'posts' => $posts,
        ]);
    }

    public function edit(Community $community): \Inertia\Response {
        return Inertia::render('Communities/Edit',  [
            'community' => $community
        ]);
    }

    public function update(CommunityStoreRequest $request, Community $community): \Illuminate\Http\RedirectResponse {
        $community->update($request->validated());

        return redirect()->route('communities.index')->with('message', 'Community Updated Successfully');
    }

    public function destroy(Community $community): \Illuminate\Http\RedirectResponse {
        $community->delete();

        return redirect()->route('communities.index')->with('message', 'Community Deleted Successfully');
    }
}
