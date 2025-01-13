<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $table = 'roles_permissions';

    protected $fillable = [
        'role',
        'can_upload',
        'can_download',
        'can_comment',
        'can_rate',
        'can_view',
    ];
}
