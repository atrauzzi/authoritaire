<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class AuthoritaireInit extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        // Create the role/user relationship table
        Schema::create('authoritaire_memberships', function (Blueprint $table) {

            $table
            	->integer('authorizable_id')
            	->unsigned()
            	->index()
            ;

            $table->string('authorizable_type');

            $table
            	->integer('role_id')
            	->unsigned()
            	->index()
            ;

            $table->timestamps();

            $table->primary([
            	'authorizable_id',
            	'authorizable_type'
            ], 'authoritaire_memberships_primary');

        });

        // Create the permissions table
        Schema::create('authoritaire_permissions', function (Blueprint $table) {

    		$table
            	->increments('id')
            	->unsigned()
            ;

            $table
            	->string('name', 100)
            	->index()
            ;

            $table
            	->string('description', 255)
            	->nullable()
            ;

			$table->timestamps();

        });

        // Create the roles table
        Schema::create('authoritaire_roles', function (Blueprint $table) {

            $table
            	->increments('id')
            	->unsigned()
            ;

            $table
            	->string('name', 100)
            	->index()
            ;

            $table
            	->string('description', 255)
            	->nullable()
            ;

            $table->timestamps();

        });

        // Create the permission/role relationship table
        Schema::create('authoritaire_role_permissions', function (Blueprint $table) {

            $table
            	->integer('permission_id')
            	->unsigned()
            	->index()
            ;

            $table
            	->integer('role_id')
            	->unsigned()
            	->index()
            ;

            $table->timestamps();

        });

    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('authoritaire_memberships');
		Schema::drop('authoritaire_role_permissions');
		Schema::drop('authoritaire_roles');
		Schema::drop('authoritaire_permissions');
	}

}
