# Authorization for Eloquent Models

Authoritaire is an attempt to create an [orthogonal](http://goo.gl/JXLzBm) simple authorization library.  The premise came after seeing many Laravel 4 user libraries that couple too tightly with projects and attempt to do too much.

Authoritaire facilitates role-based and permissions-per-role authorization checks.  Many systems can get by using only roles, however if you need more fine-grained control over things, permissions are available.


## Usage

Using Authoritaire is as simple as running the migration:

    ./artisan migrate --package="atrauzzi/authoritaire"

And then add the [trait](http://goo.gl/Z62lC) `Authorizable` to any model you wish to perform permission checks on.

    use Atrauzzi\Authoritaire\Model\Authorizable;
  
    class User implements UserInterface, RemindableInterface {
      use Authorizable;
      
      // ...

You can create new `Permissions` by instantiating them and relating them to a `Role`.  

    $eatPlants = Atrauzzi\Authoritaire\Model\Permission::create([
      'name' => 'Eat Plants'
    ]);
    
    $vegetarian = Atrauzzi\Authoritaire\Model\Role::create([
      'name' => 'Vegetarian',
      'description' => 'Does not eat meat.'
    ]);
    $vegetarian->permissions()->save($eatPlants);


You can grant authorizables membership to `Roles` from either side using `addRole()` from `Authorizable` or `addAuthorizable()` from `Role`:

    $a = User::first();
    $r = Atrauzzi\Authoritaire\Model\Role::where('name', '=', 'Vegetarian')->first();
    
    // Add from authorizable-side.
    $a->addRole($r);
    // Or add from role-side.
    $r->addAuthorizable($a);

Performing checks is as simple as asking the user if they are either a member of a role or have access to a permission.  Authoritaire will take care of everything.

    $u->is('Vegetarian');                       // true
    $u->can('Eat Plants');                      // true
    $u->is('Administrator');                    // false
    
    // You can also perform checks for a set of permissions or roles.
    $u->is(['Administrator', 'Vegetarian']);    // false

### Currently
This version of Authoritaire makes use of some workarounds due to [limitations in Laravel 4's polymorphic relations](https://github.com/laravel/framework/issues/1922).  As such, one join table has to be more directly manipulated than I would have liked.


## License

The Laravel framework is open-sourced software license under the [MIT license](http://goo.gl/tuwnQ)

This project is too to ensure maximum compatibility.

## Meta

I'm interested in hearing feedback and suggestions about this package.  Please feel free to submit a ticket at any time.

Visit authoritaire:

* ...[on packagist](https://packagist.org/packages/atrauzzi/authoritaire)

* ...[at Sensio Labs Connect](https://connect.sensiolabs.com/profile/omega/project/atrauzzi-authoritaire)

Authoritaire is made by [Alexander Trauzzi](http://goo.gl/QabWv)

A big thank you to [Todd Francis](http://goo.gl/x3MAuE) for his original work on [Verify-L4](http://goo.gl/NlDoFl)!  While I didn't keep the lion's share of his work, it has mostly inspired the schema.
