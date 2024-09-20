<?php

namespace App\Repositories;
use App\Interfaces\GroupInterface;
use App\Models\Group;
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

        return Group::create($data);
    }

    public function update(array $data, string $id)
    {
        return Group::findOrFail($id)->update($data);
    }

    public function destroy(string $id)
    {
        return Group::destroy($id);
    }

    public function show(string $id)
    {
        return Group::findOrFail($id);
    }

}
