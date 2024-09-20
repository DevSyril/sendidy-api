<?php

namespace App\MailSender;
use App\Mail\GroupMemberNotifications;
use App\Models\GroupMember;
use App\Models\User;
use Mail;

class SendMailToGroupMembers
{
    public static function sendMail(array $data)
    {

        $groupMembers = GroupMember::where('group_id', $data['group_id'])->get();

        foreach ($groupMembers as $member) {
            $userName = User::firstWhere('email', $member->member_email);
            Mail::to($member->member_email)->send(new GroupMemberNotifications(
                $data['sender'],
                isset($userName->username) && $userName->username!= null ? $userName->username : $member->member_email,
                $data['group'],
                $data['subject'],
                $data['messageContent'],
            ));
        }
    }
}
