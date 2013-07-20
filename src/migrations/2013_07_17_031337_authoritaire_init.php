<?php

use Illuminate\Database\Migrations\Migration;

class AuthoritaireInit extends Migration {

	protected $useForeignKeys;

    public function __construct() {
        // Get the prefix
        $this->userTable = Config::get('authoritaire::user_table', 'users');
        $this->useForeignKeys = Config::get('authoritaire::use_foreign_keys', false);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        // Create the users table
        Schema::create($this->prefix.'users', function($table) {

            $table
            	->increments('id')
            	->unsigned()
            ;

            $table
            	->string('username', 30)
            	->index()
            ;

            $table
            	->string('salted_password', 60)
            	->index()
            ;

            $table
            	->string('email', 255)
            	->index()
            ;

            $table
            	->boolean('verified')
            	->default(0)
            ;

            $table
            	->boolean('disabled')
            	->default(0)
            ;

            $table
            	->dateTime('deleted_at')
            	->nullable()
            	->index()
            ;

            $table->timestamps();

        });

        // Create the permissions table
        Schema::create($this->prefix.'permissions', function ($table) {

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
        Schema::create($this->prefix.'roles', function ($table) {

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

            $table->integer('level');

            $table->timestamps();

        });

        // Create the role/user relationship table
        Schema::create($this->prefix.'role_user', function ($table) use ($this->prefix, $this->useForeignKeys) {

            $table
            	->integer('user_id')
            	->unsigned()
            	->index()
            ;

            $table
            	->integer('role_id')
            	->unsigned()
            	->index()
            ;

            $table->timestamps();

			if($this->useForeignKeys) {
				$table
					->foreign('user_id')
					->references('id')
					->on($this->prefix.'users')
				;

				$table
					->foreign('role_id')
					->references('id')
					->on($this->prefix.'roles')
				;
			}

        });

        // Create the permission/role relationship table
        Schema::create($this->prefix.'permission_role', function($table) use ($this->prefix, $this->useForeignKeys) {

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

			if($this->useForeignKeys) {
				$table
					->foreign('permission_id')
					->references('id')
					->on($this->prefix.'permissions')
				;

				$table
					->foreign('role_id')
					->references('id')
					->on($this->prefix.'roles')
				;
			}

        });

    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop($this->prefix.'role_user');
		Schema::drop($this->prefix.'permission_role');
		Schema::drop($this->prefix.'users');
		Schema::drop($this->prefix.'roles');
		Schema::drop($this->prefix.'permissions');
	}

}
