<?php namespace Atrauzzi\Authoritaire\Model;

use Illuminate\Database\Eloquent\Model;


class Membership extends Model {

    protected $table = 'authoritaire_memberships';

    public function role() {
    	return $this->belongsTo('Atrauzzi\Authoritaire\Model\Role');
    }

    public function authorizable() {
		return $this->morphTo();
    }

}