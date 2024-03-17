<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PermissinsController extends Controller
{
    public function permit()
    {
        $user = User::find(1);
        $adminRole = Role::where('name', 'admin')->first();

        $readPermission = Permission::where('name', 'read')->first();


        $user->roles()->attach($adminRole);
        $adminRole->permissions()->attach($readPermission);

        dd($readPermission);
        dd($user , $adminRole);
    }

    public function canView()
    {
        dd(auth()->user()->hasRole('adamin'));

        if (auth()->user()->hasPermission('read')) {
            // Allow access to a specific resource with "read" permission
        }
          return view('can');
    }
}
