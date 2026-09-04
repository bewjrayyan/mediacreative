<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamMemberRequest;
use App\Http\Requests\Admin\UpdateTeamMemberRequest;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = TeamMember::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('position', 'like', "%{$search}%");
        }

        $team = $query->orderBy('sort_order')->orderBy('id')->paginate(10)->withQueryString();

        return view('admin.team.index', compact('team'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(StoreTeamMemberRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['social_links'] = array_filter($request->input('social_links', []));

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member created successfully.');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('admin.team.edit', compact('teamMember'));
    }

    public function update(UpdateTeamMemberRequest $request, TeamMember $teamMember)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['social_links'] = array_filter($request->input('social_links', []));

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $teamMember->update($data);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member deleted successfully.');
    }

    public function toggle(TeamMember $teamMember)
    {
        $teamMember->update(['is_active' => ! $teamMember->is_active]);

        return back()->with('success', 'Team member status updated.');
    }
}
