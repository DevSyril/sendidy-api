<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\CreateGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Resources\GroupResources;
use App\Interfaces\GroupInterface;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController
{
    private GroupInterface $groupInterface;

    public function __construct(GroupInterface $groupInterface)
    {
        $this->groupInterface = $groupInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateGroupRequest $request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'creationDate' => date('Y-M-D')
        ];

        try {

            $group = $this->groupInterface->store($data);

            return ApiResponse::sendResponse(true, $group, 'Groupe créé avec succès.', 201);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {

            $group = $this->groupInterface->show($id);

            return ApiResponse::sendResponse(true, [new GroupResources($group)], 'Opération effectuée avec succès.', 201);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, string $id)
    {
        $group = $this->groupInterface->show($id);

        $data = [
            'name' => $request->name ? $request->name : $group->name,
            'description' => $request->description ? $request->description : $group->description
        ];

        $destinationPath = 'db/groupDatas/profileImages/';

        if ($request->hasFile("profilePhoto")) {

            $file = $request->file('profilePhoto');
            $fileName = $file->getClientOriginalName();

            if ($file->move($destinationPath, $fileName)) {
                $data['profilePhoto'] = str_replace(' ','_', $fileName);
            } else {
                return response()->json(['error' => 'Echec du téléchargement du fichier'], 500);
            }

        }

        DB::beginTransaction();

        try {

            $this->groupInterface->update($data, $id);

            DB::commit();

            return ApiResponse::sendResponse(true, $data, 'Opération effectuée.', 201);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $this->groupInterface->destroy($id);

            return ApiResponse::sendResponse(true, [], 'Groupe créé avec succès.', 201);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }

    public function getUserGroups() {
        try {

            $groups = $this->groupInterface->getUserGroups();

            return ApiResponse::sendResponse(true, $groups, 'Groupes récupérés avec succès.', 200);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }

    public function searchGroup(string $group) {
        try {

            $group = $this->groupInterface->searchGroup($group);

            return ApiResponse::sendResponse(true, $group, 'Groupes récupérés avec succès.', 200);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }
}
