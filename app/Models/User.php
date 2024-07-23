<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
	use HasRoles, HasPermissions, HasFactory, Notifiable;

	public $table = 'users';

	protected $fillable = [
		'name',
		'email',
		'password',
		'status',
        'profile_image',
	];

	public static $rules = [
		'email' => 'required|email:rfc,dns|max:255|unique:users,email',
		'name' => 'required|max:255',
		//'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
	];

	public static $messages = [
		//'password.regex' => 'password must Contain at least one uppercase/lowercase letters, one number and one special char'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function isSuperAdmin() {
		return $this->hasRole(Role::SUPPER_ADMIN);
	}
	protected $appends = array('role_data', 'role_text', 'check_supper_admin');
	public function getRoleDataAttribute() {
		return $this->roles->pluck('id', 'name');
	}
	public function getRoleTextAttribute() {
		return $this->roles->pluck('name')->implode(',');
	}
	public function getCheckSupperAdminAttribute() {
		return $this->hasRole(Role::SUPPER_ADMIN);
	}

	// public function roles() {
	//     return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
	// }

	// public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    // }
}
