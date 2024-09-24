<?php

namespace App\Repositories;
use App\Interfaces\UserInterface;
use App\Mail\OtpCodeMail;
use App\Mail\PasswordResetMail;
use App\MailSender\SendMailToGroupMembers;
use App\Models\GroupMember;
use App\Models\Invitations;
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

        $invitationCheck = Invitations::firstWhere('invited_email', $data['email']);

        if ($invitationCheck) {

            $newMember = [
                'member_email' => $invitationCheck->invited_email,
                'group_id' => $invitationCheck->group_id,
                'invitation_sender' => $invitationCheck->invitation_sender,
                'date' => date('Y-m-d')
            ];

            GroupMember::create($newMember);

            $groupInfos = [
                'sender' => $invitationCheck->invitation_sender,
                'group_id' => $invitationCheck->group_id,
                'group' => $invitationCheck->group_name,
                'subject' => "Ajout d'un nouveau membre au groupe",
                'messageContent' => "d' ajouter un nouveau membre au groupe",
            ];

            SendMailToGroupMembers::sendMail($groupInfos);

            Invitations::destroy($invitationCheck->id);
        }

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

        $otp = OtpCode::where('email', $email)->first();

        if ($otp)
            OtpCode::destroy($otp->id);
        
        OtpCode::create($data);

        Mail::to($email)->send(new PasswordResetMail($user->username, $email, $data['code']));

        return $user;
    }
}
