<?php

namespace App\Repositories;
use App\Interfaces\UserInterface;
use App\Mail\OtpCodeMail;
use App\Mail\PasswordResetMail;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Mail;

class UserRepository implements UserInterface
{
    public function index()
    {
        return User::all();
    }



    public function store(array $data)
    {
        $user = User::create($data);

        $verification = [
            'email' => $data['email'],
            'code' => rand(111111, 999999)
        ];

        OtpCode::create($verification);

        Mail::to($data['email'])->send(new OtpCodeMail($data['username'], $data['email'], $verification['code']));

        return $user;
    }


    public function update(array $data, string $id)
    {
        return User::findOrFail($id)->update($data);
    }



    public function destroy(string $id)
    {
        return User::destroy($id);
    }



    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return $user;
    }



    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {

            $user->tokens()->delete();
            $user->token = $user->createToken($user->id)->plainTextToken;

            return $user;
        }

        return false;
    }



    public function resetPassword(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        $data = [
            'email' => $email,
            'code' => rand(111111, 999999)
        ];

        OtpCode::create($data);

        Mail::to($email)->send(new PasswordResetMail($user->username, $email, $data['code']));

        return $user;
    }
}
