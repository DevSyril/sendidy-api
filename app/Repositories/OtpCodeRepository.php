<?php

namespace App\Repositories;
use App\Interfaces\OtpCodeInterface;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OtpCodeRepository implements OtpCodeInterface
{
    public function checkOtpCode(array $data) {

        $otp_code = OtpCode::where('email', $data["email"])->first();

        if (!$otp_code)
            return false;

        if (Hash::check($data['code'], $otp_code['code'])) {

            $user = User::where('email', $data['email'])->first();
            $user->update(['is_confirmed' => 1]);
            $otp_code->delete();

            $user->token = $user->createToken($user->id)->plainTextToken;

            return $user;

        }

        return false;
    }
}
