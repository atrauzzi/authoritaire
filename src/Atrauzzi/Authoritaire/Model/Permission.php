<?php namespace Atrauzzi\Authoritaire\Model;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model {

    protected $table = 'authoritaire_permissions';

    protected $fillable = [
    	'name',
    	'description'
    ];

    public function roles() {
		return $this
			->belongsToMany(
				'Atrauzzi\Authoritaire\Model\Role',
				'authoritaire_role_permissions'
            )
			->withTimestamps()
		;
    }

}