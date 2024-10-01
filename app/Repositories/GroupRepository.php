<?php

namespace App\Repositories;
use App\Interfaces\GroupInterface;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;

class GroupRepository implements GroupInterface
{
    public function index()
    {
        return Group::all();
    }

    public function store(array $data)
    {

        $user = User::find(auth()->user()->getAuthIdentifier());

        $data['owner_id'] = $user->id;

        $group = Group::create($data);

        $member = [
            'group_id' => $group->id,
            'member_email' => $user->email,
        ];

        GroupMember::create($member);

        return $group;

    }

    public function update(array $data, string $id)
    {
        return Group::findOrFail($id)->update($data);
    }

    public function delete(string $id)
    {
        return Group::destroy($id);
    }

    public function show(string $id)
    {
        return Group::findOrFail($id);
    }

    public function getUserGroups() {

        $user = User::find(auth()->user()->getAuthIdentifier());

        $groups = GroupMember::where('member_email', $user->email)->get();

        $myGroups = array();

        foreach ($groups as $group) {
            array_push($myGroups, Group::where('id', $group->group_id)->first());
        }

        return $myGroups;
    }

    public function searchGroup(string $group) {
        
        return Group::where('name', 'like', '%'.$group.'%')->get();
    }


}
