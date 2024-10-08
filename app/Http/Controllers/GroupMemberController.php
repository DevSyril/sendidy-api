<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\AddMemberRequest;
use App\Interfaces\GroupMemberInterface;
use App\Models\GroupMember;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;

class GroupMemberController
{

    private GroupMemberInterface $groupMemberInterface;

    public function __construct(GroupMemberInterface $groupMemberInterface)
    {
        $this->groupMemberInterface = $groupMemberInterface;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddMemberRequest $request)
    {

        $data = [
            'group_id' => $request->group_id,
            'date' => date('Y-m-d'),
            'member_email' => $request->member_email
        ];

        try {

            $member = GroupMember::where('member_email', $request->member_email)->first();

            if ($member)
            {
                return ApiResponse::sendResponse(false, $member, 'Ce membre existe déjà.', 200);
            }

            $member = $this->groupMemberInterface->addMember($data);

            return ApiResponse::sendResponse(true, $member, 'Nouveau membre ajouté avec succès.', 201);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }


    public function getGroupMembers(string $id)
    {
        try {

            $member = $this->groupMemberInterface->getGroupMembers($id);

            if (!$member) {
                return ApiResponse::sendResponse(false, $member, 'Aucun membre trouvé.', 200);
            }

            return ApiResponse::sendResponse(true, $member, 'Opération effectuée.', 200);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
