<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResources;
use App\Interfaces\OtpCodeInterface;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtpCodeController
{

    private OtpCodeInterface $otpCodeInterface;

    public function __construct(OtpCodeInterface $otpCodeInterface)
    {
        $this->otpCodeInterface = $otpCodeInterface;
    }

    public function checkOtpCode(Request $request)
    {

        $data = [
            'email' => $request->email,
            'code' => $request->code,
        ];

        DB::beginTransaction();

        try {

            $user = $this->otpCodeInterface->checkOtpCode($data);

            DB::commit();

            if (!$user) {
                return ApiResponse::sendResponse(
                    false,
                    [],
                    'Code de confirmation invalide.',
                    200
                );
            }

            return ApiResponse::sendResponse(
                true,
                $user,
                'Bienvenue '.$user->username,
                200
            );


        } catch (\Throwable $ex) {
            return ApiResponse::rollback($ex);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
