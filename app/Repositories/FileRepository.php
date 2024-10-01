<?php

namespace App\Repositories;
use App\Interfaces\FileInterface;
use App\Mail\GroupMemberNotifications;
use App\MailSender\SendMailToGroupMembers;
use App\Models\File;
use App\Models\Group;
use App\Models\User;


class FileRepository implements FileInterface
{
    public function store(array $data)
    {
        $currentUser = User::find(auth()->user()->getAuthIdentifier());

        $data['sender'] = $currentUser->username;
        $file = File::create($data);

        $group = Group::where('id', $data['group_id'])->first();

        $mailInfos = [
            'sender' => $currentUser->username,
            'group_id' => $data['group_id'],
            'group' => $group->name,
            'subject' => "Nouveau fichier",
            'messageContent' => "d'ajouter un nouveau fichier au groupe",   
        ];

        SendMailToGroupMembers::sendMail($mailInfos);

        return $file;
    }

}
