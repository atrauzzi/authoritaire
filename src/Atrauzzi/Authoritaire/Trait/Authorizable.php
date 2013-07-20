<?php
namespace Atrauzzi\Authoritaire\Trait;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

trait Authorizable {

    public function roles() {
		return $this
			->belongsToMany('Atrauzzi\Authoritaire\Model\Role')
			->withTimestamps()
		;
    }

    public function permissions() {
    	return $this
    		->belongsToMany(
    			'Atrauzzi\Authoritaire\Model\Permission'
    			''
    		)
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

    /**
     * Is the User a certain Level
     *
     * @param  integer $level
     * @param  string $modifier [description]
     * @return boolean
     */
    public function level($level, $modifier = '>=')
    {
        $to_check = $this->getToCheck();

        $max = -1;
        $min = 100;
        $levels = array();

        foreach ($to_check->roles as $role)
        {
            $max = $role->level > $max
                ? $role->level
                : $max;

            $min = $role->level < $min
                ? $role->level
                : $min;

            $levels[] = $role->level;
        }

        switch ($modifier)
        {
            case '=':
                return in_array($level, $levels);
                break;

            case '>=':
                return $max >= $level;
                break;

            case '>':
                return $max > $level;
                break;

            case '<=':
                return $min <= $level;
                break;

            case '<':
                return $min < $level;
                break;

            default:
                return false;
                break;
        }
    }

    /**
     * Verified scope
     *
     * @param  object $query
     * @return object
     */
    public function scopeVerified($query)
    {
        return $query->where('verified', '=', 1);
    }

    /**
     * Unverified scope
     *
     * @param  object $query
     * @return object
     */
    public function scopeUnverified($query)
    {
        return $query->where('verified', '=', 0);
    }

    /**
     * Disabled scope
     *
     * @param  object $query
     * @return object
     */
    public function scopeDisabled($query)
    {
        return $query->where('disabled', '=', 1);
    }

    /**
     * Enabled scope
     *
     * @param  object $query
     * @return object
     */
    public function scopeEnabled($query)
    {
        return $query->where('disabled', '=', 0);
    }
}
