<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Spatie\Permission\Models\Role;

class UsersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $role = Role::find(2);
        return view('admin.users.export', [
            'users' =>   User::role($role->name)->get()
        ]);
    }
}
