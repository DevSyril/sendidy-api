<?php

namespace App\Interfaces;

interface GroupMemberInterface
{
    public function addMember(array $data);
    public function getGroupMembers(string $id);
}
