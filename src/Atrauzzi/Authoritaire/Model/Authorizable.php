<?php namespace Atrauzzi\Authoritaire\Model;

use Atrauzzi\Authoritaire\Model\Role;


/**
 * Interface models must implement to access the roles/permissions system
 *
 * Interface Authorizable
 * @package Atrauzzi\Authoritaire\Model
 */
interface Authorizable {

    public function roles();

    public function addRole(Role $role);

    public function memberships();

    public function permissions();

	/**
	 * @param string[]|string $checkRoles
	 * @return bool
	 */
	public function is($checkRoles);

	/**
	 * @param string[]|string $checkPermissions
	 * @return bool
	 */
	public function can($checkPermissions);

}