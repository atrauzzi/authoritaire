<?php namespace Atrauzzi\Authoritaire\Model;

use Illuminate\Database\Eloquent\Model;


class Role extends Model {

    protected $table = 'authoritaire_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name',
    	'description',
    	'level'
    ];

    protected $with = [
    	'permissions'
    ];

    public function authorizables() {
    	return $this
    		->memberships()
    		->authorizable()
    	;
    }

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
    	return $this
    		->hasMany('Atrauzzi\Authoritaire\Model\Membership')
    		->withTimestamps()
    	;
    }

}