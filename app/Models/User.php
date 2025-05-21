<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'branch_id',
        'username',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isHeadOfDepartment()
    {
        return $this->role === 'head_of_department';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isHeadOfficeStaff()
    {
        return $this->role === 'head_office_staff';
    }

    public function canAssignTickets()
    {
        return $this->isAdmin() || $this->isHeadOfDepartment();
    }
}





