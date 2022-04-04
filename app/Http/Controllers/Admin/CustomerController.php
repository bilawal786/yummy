<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Http\Requests\CustomerRequest;
use App\Models\Location;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopProduct;
use App\Refferal;
use App\User;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
class CustomerController extends BackendController
{
    public function __construct()
    {
        $this->data['siteTitle'] = 'Customers';

        $this->middleware(['permission:customers'])->only('index');
        $this->middleware(['permission:customers_create'])->only('create', 'store');
        $this->middleware(['permission:customers_edit'])->only('edit', 'update');
        $this->middleware(['permission:customers_delete'])->only('destroy');
        $this->middleware(['permission:customers_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role      = Role::find(2);
        $users     = User::role($role->name)->latest()->get();
        $this->data['location'] = Location::all();
        $this->data['users'] = $users;
        return view('admin.customer.index', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find(2);

        $this->data['user'] = User::role($role->name)->findOrFail($id);
        return view('admin.customer.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find(2);

        $this->data['user'] = User::role($role->name)->findOrFail($id);
        $this->data['location'] = Location::all();
        return view('admin.customer.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $role = Role::find(2);
        $user = User::role($role->name)->findOrFail($id);
        $balance = Balance::where('id', $user->balance_id)->first();

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username ?? $this->username($request->email);

        if ($request->password) {
            $user->password = Hash::make(request('password'));
        }

        $user->phone   = $request->phone;
        $user->address = $request->address;
        $user->status  = $request->status;
        $user->save();
        $balance->balance = $request->credit;
        $balance->save();

        if (request()->file('image')) {
            $user->media()->delete();
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(2);
        $user->assignRole($role->name);

        return redirect(route('admin.customers.index'))->withSuccess('The Data Updated Successfully');
    }

    public function getCustomers()
    {
        $role      = Role::find(2);
        $users     = User::role($role->name)->latest()->get();
        $userArray = [];

        $i = 1;
        if (!blank($users)) {
            foreach ($users as $user) {
                $userArray[$i]          = $user;
                $userArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($userArray)
            ->addColumn('action', function ($user) {
                $retAction = '';

                if (auth()->user()->can('customers_edit')) {
                    $retAction .= '<a href="' . route('admin.customers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                }

                return $retAction;
            })
            ->addColumn('image', function ($user) {
                return '<figure class="avatar mr-2"><img src="' . $user->images . '" alt=""></figure>';
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('sponsership', function ($user) {
                $refferal = Refferal::where('refferal_user', $user->id)->count();
                return $refferal;
            })
            ->addColumn('coins', function ($user) {
                return $user->balance->balance;
            })
            ->editColumn('id', function ($user) {
                return $user->setID;
            })
            ->escapeColumns([])
            ->make(true);
    }
    public function getCustomersCountry($id)
    {
        $role      = Role::find(2);
        $users     = User::role($role->name)->where('address', $id)->latest()->get();
        $userArray = [];

        $i = 1;
        if (!blank($users)) {
            foreach ($users as $user) {
                $userArray[$i]          = $user;
                $userArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($userArray)
            ->addColumn('action', function ($user) {
                $retAction = '';

                if (auth()->user()->can('customers_edit')) {
                    $retAction .= '<a href="' . route('admin.customers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                }

                return $retAction;
            })
            ->addColumn('image', function ($user) {
                return '<figure class="avatar mr-2"><img src="' . $user->images . '" alt=""></figure>';
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('id', function ($user) {
                return $user->setID;
            })
            ->escapeColumns([])
            ->make(true);
    }

    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function countryUsers($id){
        $this->data['location'] = Location::all();
        $this->data['id'] = $id;
        return view('admin.customer.countryUsers', $this->data);
    }
    public function shopAdmins(){
        $role      = Role::find(5);
        $users     = User::role($role->name)->latest()->get();
        return view('admin.shopadmins.index', compact('users'));
    }
    public function createShopAdmins(){
        $shops = Shop::all();
        return view('admin.shopadmins.create', compact('shops'));
    }
    public function storeShopAdmins(Request $request){
        $user             = new User;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username ?? $this->username($request->email);
        $user->password   = Hash::make(request('password'));
        $user->phone      = $request->phone;
        $user->address    = $request->address;
        $user->status     = $request->status;
        if($request->shops){
            foreach($request->shops as $shop)
            {
                $data[] = $shop;
                $user->shopadmins = json_encode($data);
            }
        }
        if ($request->p1){
            $user->p1 = $request->p1;
        }else{
            $user->p1 = 0;
        }
        if ($request->p2){
            $user->p2 = $request->p2;
        }else{
            $user->p2 = 0;
        }
        if ($request->p3){
            $user->p3 = $request->p3;
        }else{
            $user->p3 = 0;
        }
        if ($request->p4){
            $user->p4 = $request->p4;
        }else{
            $user->p4 = 0;
        }
        if ($request->p5){
            $user->p5 = $request->p5;
        }else{
            $user->p5 = 0;
        }
        if ($request->p6){
            $user->p6 = $request->p6;
        }else{
            $user->p6 = 0;
        }
        if ($request->p7){
            $user->p7 = $request->p7;
        }else{
            $user->p7 = 0;
        }
        if ($request->p8){
            $user->p8 = $request->p8;
        }else{
            $user->p8 = 0;
        }
        if ($request->p9){
            $user->p9 = $request->p9;
        }else{
            $user->p9 = 0;
        }
        if ($request->p10){
            $user->p10 = $request->p10;
        }else{
            $user->p10 = 0;
        }
        $user->save();

        if (request()->file('image')) {
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(5);
        $user->assignRole($role->name);

        return redirect(route('admin.shop.admins'))->withSuccess('The Data Inserted Successfully');
    }
    public function shopAdminProducts(){
        $shopsids = json_decode(Auth::user()->shopadmins);
        $products  = ShopProduct::whereIn('shop_id', $shopsids)->get();
        return view('admin.shopadmins.products', compact('products'));
    }

}
