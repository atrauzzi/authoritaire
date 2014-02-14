<?php namespace Atrauzzi\Authoritaire\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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

		// The problem here is that I can't `fetch()` polymorphic relations.
		// So instead I get every instance of the join table model and dereference.

		$authorizables = new Collection();

		foreach($this->memberships as $membership)
			$authorizables[] = $membership->authorizable;

		return $authorizables;

	}

	// Adds a row to the join table to make the authorizable a member of a role.
	public function addAuthorizable(Model $authorizable) {

		if($authorizable instanceof AuthorizableImpl)
        {
            $membership = new Membership();
            $authorizable->memberships()->save($membership);
            $this->memberships()->save($membership);
        }
        else
        {
            throw new Exception(sprintf('The class %s does not use the AuthorizableImpl trait.', get_class($authorizable)));
        }

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