<?php namespace Atrauzzi\Authoritaire\Model;


/**
 * Interface models must implement to access the roles/permissions system
 *
 * Interface Authorizable
 * @package Atrauzzi\Authoritaire\Model
 */
interface Authorizable {

    public function roles();

    public function addRole();

    public function memberships();

    public function permissions();

    public function is();

    public function can();

}