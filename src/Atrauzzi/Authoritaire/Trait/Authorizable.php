<?php
namespace Atrauzzi\Authoritaire\Trait;


trait Authorizable {

    public function roles() {
    	return $this
    		->memberships()
    		->role()
    	;
    }

	public function permissions() {
		return $this
			->roles()
			->permissions()
		;
	}

	public function memberships() {
		return $this
			->morphMany('Atrauzzi\Authoritaire\Model\Membership', 'authorizable')
			->withTimestamps()
		;
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
