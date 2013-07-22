# Authoritaire - Laravel 4 Auth Package

Authoritaire is an attempt to create an [orthogonal](http://goo.gl/JXLzBm) simple authorization library.

The premise came after seeing many Laravel 4 user libraries that couple too tightly with projects and attempt to do too much.

## Currently

Using Authoritaire is as simple as adding the [trait](http://goo.gl/Z62lC) `Authorizable` to any model you wish to perform permission checks on and running the migration.

You can create new `Permissions` by instantiating them and relating them to a `Role`.  Similarly, you can grant authorizables membership to `Roles` from either side using `addRole()` from `Authorizable` or `addAuthorizable()` from `Role`.

This version of Authoritaire makes use of some workarounds due to [limitations in Laravel 4's polymorphic relations](https://github.com/laravel/framework/issues/1922).  As such, one join table has to be more directly manipulated than I would have liked.


# Notes

Authoritaire is created by [Alexander Trauzzi](http://goo.gl/nHw4u).

A big thank you to [Todd Francis](http://goo.gl/x3MAuE) for his original work on [Verify-L4](http://goo.gl/NlDoFl)!  While I didn't keep the lion's share of his work, it has mostly inspired the schema.

Please feel free to open a ticket with bug and improvement requests!