<?php namespace Atrauzzi\Authoritaire\Model;

use Illuminate\Database\Eloquent\Model;
use Atrauzzi\Authoritaire\Model\Membership;
use \ReflectionClass;
use \Exception;

class Role extends Model {

	protected $table = 'authoritaire_roles';

	protected $fillable = [
		'name',
		'description'
	];

	protected $with = [
		'permissions'
	];

	//
	// These are hacks until many-to-many polymorphic relations are possible.
	//
	// https://github.com/laravel/framework/issues/1922

	// A read-only "relation" to obtain all current authorizables.
	public function authorizables() {
	}

	// Adds a row to the join table to make the authorizable a member of a role.
	public function addAuthorizable(Model $authorizable) {

		// Not big on putting this in the model, but it's helpful.
		$authorizableMeta = new ReflectionClass($authorizable);
		if(!in_array('Authorizable', $authorizableMeta->getTraits()))
			throw new Exception(sprintf('The class %s does not use the Authorizable trait.', get_class($authorizable)));

		$membership = new Membership();
		$authorizable->memberships()->save($membership);
		$this->memberships()->save($membership);

	}

	/*
	// This is one possible imagining of many-to-many polymorphic relations.
	public function authorizables() {
		return $this
			->morphToMany(
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
			->belongsToMany(
				'Atrauzzi\Authoritaire\Model\Permission',
				'authoritaire_role_permissions'
			)
			->withTimestamps()
		;
	}

	public function memberships() {
		return $this->hasMany('Atrauzzi\Authoritaire\Model\Membership');
	}

}