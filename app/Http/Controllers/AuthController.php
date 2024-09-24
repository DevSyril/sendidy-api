<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\LoginRequest;
use App\Http\Requests\Users\PasswordReset;
use App\Http\Requests\Users\RegistrationRequest;
use App\Http\Resources\UserResources;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController
{

    private UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistrationRequest $request)
    {
        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ];

        try {
            $user = $this->userInterface->store($data);
            
            return ApiResponse::sendResponse(true, $user, 'Compte créé avec succès.', 201);

        } catch (\Throwable $th) {

            // return ApiResponse::rollback($th);
            return $th;
        }
    }


    public function login(LoginRequest $request)
    {

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];


        DB::beginTransaction();

        try {

            $user = $this->userInterface->login($data);

            DB::commit();

            if (!$user) {
                return ApiResponse::sendResponse(
                    false,
                    [],
                    'Identifiants invalides.',
                    200
                );

            } else {
                return ApiResponse::sendResponse(
                    true,
                    $user,
                    'Bienvenue ' . $user->username,
                    200
                );
            }


        } catch (\Throwable $ex) {
            return ApiResponse::rollback($ex);
        }

    }


    public function resetPassword(PasswordReset $request)
    {
        try {

            $user = $this->userInterface->resetPassword($request->email);

            if (!$user)
                return ApiResponse::sendResponse(false, [], 'L\'adresse e-mail n\'a pas été retrouvé.', 200);

            return ApiResponse::sendResponse(true, $user, 'Code de vérification envoyée.', 200);

        } catch (\Throwable $th) {

            return ApiResponse::rollback($th);
        }
    }

    public function logout()
    {
        try {

            $user = User::find(auth()->user()->getAuthIdentifier());

            $user->tokens()->delete();

            return ApiResponse::sendResponse(
                true,
                [],
                'utilisateur déconnecté',
                200
            );
        } catch (\Throwable $th) {
            return ApiResponse::rollback($th);
        }
    }

    
}
