<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitations extends Model
{
    use HasFactory;

    protected $fillable = [
        'invited_email',
        'group_id',
        'invitation_sender',
        'group_name'
    ];

}
