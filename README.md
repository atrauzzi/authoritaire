# Authoritaire - Laravel 4 Auth Package

Authoritaire is an attempt to create a an (orthogonal)[http://en.wikipedia.org/wiki/Orthogonality_(programming)] simple authorization library.

The premise came after seeing many Laravel 4 user libraries that couple too tightly with projects and attempt to do too much.

## Currently

Using Authoritaire is as simple as adding the (trait)[http://php.net/manual/en/language.oop5.traits.php] `Authorizable` to any model you wish to perform permission checks on and running the migration.

You can create new `Permissions` by instantiating them and relating them to a `Role`.  Similarly, you can grant authorizables membership to `Roles` from either side using `addRole()` from `Authorizable` or `addAuthorizable()` from `Role`.

This version of Authoritaire makes use of some workarounds due to (limitations in Laravel 4's polymorphic relations)[https://github.com/laravel/framework/issues/1922].  As such, one join table has to be more directly manipulated than I would have liked.


# Notes

Authoritaire is created by (Alexander Trauzzi)[http://profiles.google.com/atrauzzi].

A big thank you to (Todd Francis)[https://github.com/Toddish] for his original work on (Verify-L4)[https://github.com/Toddish/Verify-L4]!  While I didn't keep the lion's share of his work, it has mostly inspired the schema.

Please feel free to open a ticket with bug and improvement requests!