<?php namespace Atrauzzi\Authoritaire\Model;

use Atrauzzi\Authoritaire\Model\Membership;
use Atrauzzi\Authoritaire\Model\Role;


trait Authorizable {

	//
	// These are hacks until many-to-many polymorphic relations are possible.
	//
	// https://github.com/laravel/framework/issues/1922

	// A read-only "relation" to obtain all current roles.
	public function roles() {
		return $this
			->belongsToMany(
				'Atrauzzi\Authoritaire\Model\Role',
				'authoritaire_memberships',
				'authorizable_id'
			)
			->where('authorizable_type', '=', get_called_class())
		;
	}

	// Adds a row to the join table to make the authorizable a member of a role.
	public function addRole(Role $role) {

		$membership = new Membership();
		$role->memberships()->save($membership);
		$this->memberships()->save($membership);

	}

	/*
	// This is one possible imagining of many-to-many polymorphic relations.
	public function roles() {
		return $this
			->morphManyToMany(
				'Atrauzzi\Authoritaire\Model\Role',	// Model to relate to.
				'authorizable',						// Morph label.
				'authoritaire_memberships'			// Join table.
			)
		;
	}
	*/
	//
	//
	//

	public function permissions() {
		return $this
			->roles()
			->permissions()
		;
	}

	public function memberships() {
		return $this->morphMany('Atrauzzi\Authoritaire\Model\Membership', 'authorizable');
	}

	public function is($checkRoles) {

 		$checkRoles = is_array($checkRoles) ? $checkRoles : func_get_args();
 		$roles = $this
 			->roles()
 			->lists('name')
 		;

 		if(array_intersect($checkRoles, $roles) == $checkRoles)
 			return true;

		return false;

	}

	public function can($checkPermissions) {

		$checkPermissions = is_array($checkPermissions) ? $checkPermissions : func_get_args();
		$permissions = $this
			->permissions()
			->lists('name')
		;

		if(array_intersect($checkPermissions, $permissions) == $checkPermissions)
			return true;

		return false;

	}

}
