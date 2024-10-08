<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\EditUserProfileRequest;
use App\Http\Resources\UserResources;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController
{
    private UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function changePassword(ChangePasswordRequest $request, string $id) {

        $data = [
            'password' => $request->password
        ];

        try {
            $user = $this->userInterface->update($data);

            return ApiResponse::sendResponse(true, [], 'Mot de passe modifié avec succès.', 201);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);
        }
    }

    public function update(EditUserProfileRequest $request) {

        $currentUser = User::find(auth()->user()->getAuthIdentifier());
        $user = $this->userInterface->show($currentUser->id);

        $data = [
            'username' => $request->username ? $request->username : $user->username,
            'phoneNumber' => $request->phoneNumber ? $request->phoneNumber : $user->phoneNumber
        ];

        if ($request->password != null) {
            $data['password'] = $request->password;
        };

        $destinationPath = 'db/userDatas/profileImages/';

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

            $this->userInterface->update($data);

            DB::commit();

            return ApiResponse::sendResponse(true, $data, 'Opération effectuée.', 201);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }


    public function index() {
        try {

            $users = $this->userInterface->index();

            return ApiResponse::sendResponse(true, $users, 'Opération effectuée.', 200);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);

        }
    }
}
