<?php

namespace App\Repositories;
use App\Interfaces\GroupMemberInterface;
use App\Mail\AddGroupMemberNotificationMail;
use App\Mail\GroupMemberNotifications;
use App\Mail\NewGroupMemberMail;
use App\MailSender\SendMailToGroupMembers;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Invitations;
use App\Models\User;
use Mail;

class GroupMemberRepository implements GroupMemberInterface
{
    public function addMember(array $data)
    {

        $groupMember = [];

        $user = User::find(auth()->user()->getAuthIdentifier());
        $data['invitation_sender'] = $user->username;


        $memberVerified = User::where('email', $data['member_email'])->first();
        $group = Group::where('id', $data['group_id'])->first();

        $groupLink = 'localhost:8000/';

        if ($memberVerified) {
            Mail::to($data['member_email'])->send(new AddGroupMemberNotificationMail(
                $data['invitation_sender'],
                $memberVerified->username,
                $groupLink,
                $group->name
            ));

            $groupMember = GroupMember::create($data);

            $groupInfos = [
                'sender' => $user->username,
                'group_id' => $data['group_id'],
                'group' => $group->name,
                'subject' => "Ajout d'un nouveau membre au groupe",
                'messageContent' => "d' ajouter un nouveau membre au groupe",
            ];

            SendMailToGroupMembers::sendMail($groupInfos);

        }else {

            Mail::to($data['member_email'])->send(new NewGroupMemberMail(
                $data['invitation_sender'],
                $data['member_email'],
                $groupLink,
                $group->name
            ));

            $invitation = [
                'invited_email' => $data['member_email'],
                'group_id' => $data['group_id'],
                'invitation_sender' => $data['invitation_sender'],
                'group_name' => $group->name,
            ];
            Invitations::create($invitation);
        }

        return $groupMember;
    }

}
