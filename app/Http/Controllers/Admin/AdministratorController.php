<?php

namespace App\Http\Controllers\Admin;

use App\Documents;
use App\Enums\UserStatus;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\Shop;
use App\Models\ShopProduct;
use App\Mysettings;
use App\Rank;
use App\Scale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\BackendController;
use App\Http\Requests\AdministratorRequest;
use App\Models\Location;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use App\Models\Balance;
class AdministratorController extends BackendController
{
    public function __construct()
    {
        $this->data['siteTitle'] = 'Administrator';

        $this->middleware(['permission:administrators'])->only('index');
        $this->middleware(['permission:administrators_create'])->only('create', 'store');
        $this->middleware(['permission:administrators_edit'])->only('edit', 'update');
        $this->middleware(['permission:administrators_delete'])->only('destroy');
        $this->middleware(['permission:administrators_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.administrators.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.administrators.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( AdministratorRequest $request)
    {
        $user             = new User;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username ?? $this->username($request->email);
        $user->password   = Hash::make(request('password'));
        $user->phone      = $request->phone;
        $user->address    = $request->address;
        $user->status     = $request->status;
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

        $role = Role::find(1);
        $user->assignRole($role->name);

        return redirect(route('admin.administrators.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find(1);

        $this->data['user'] = User::role($role->name)->findOrFail($id);

        return view('admin.administrators.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (($user->id != 1) || (auth()->id() == 1)) {
            $this->data['user'] = $user;
            return view('admin.administrators.edit', $this->data);
        }
        return redirect(route('admin.administrators.index'))->withError('You don\'t have permission to edit this data');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( AdministratorRequest $request, $id)
    {
        $role = Role::find(1);
        $user = User::role($role->name)->findOrFail($id);
        $balance = Balance::where('name', $user->username)->first();
        if (($user->id != 1) || (auth()->id() == 1)) {

            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email      = $request->email;
            $user->username   = $request->username ?? $this->username($request->email);

            if ($request->password) {
                $user->password = Hash::make(request('password'));
            }

            $user->phone   = $request->phone;
            $user->address = $request->address;
            if ($user->id != 1) {
                $user->status = $request->status;
            } else {
                $user->status = UserStatus::ACTIVE;
            }
            $user->save();

            $balance->balance = $request->credit;
            $balance->save();

            if (request()->file('image')) {
                $user->media()->delete();
                $user->addMedia(request()->file('image'))->toMediaCollection('user');
            }

            $role = Role::find(1);
            $user->assignRole($role->name);

            return redirect()->back()->withSuccess('The Data Updated Successfully');
        }
        return redirect(route('admin.administrators.index'))->withError('You don\'t have permission to update this data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (($user->id != 1) && (auth()->id() == 1)) {
            $user->delete();
            return redirect()->back()->withSuccess('The Data Deleted Successfully');
        } else {
            return redirect(route('admin.administrators.index'))->withError('You don\'t have permission to delete this data');
        }
    }

    public function getAdministrators()
    {
        $role      = Role::find(1);
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
                if (($user->id == auth()->id()) && (auth()->id() == 1)) {

                    if (auth()->user()->can('administrators_edit')) {
                        $retAction .= '<a href="' . route('admin.administrators.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }
                } else if (auth()->id() == 1) {

                    if (auth()->user()->can('administrators_edit')) {
                        $retAction .= '<a href="' . route('admin.administrators.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('administrators_delete')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.administrators.destroy', $user) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                    }
                } else {
                    if ($user->id == 1) {
                        if (auth()->user()->can('administrators_show')) {
                            $retAction .= '<a href="' . route('admin.administrators.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                        }
                    } else {

                        if (auth()->user()->can('administrators_edit')) {
                            $retAction .= '<a href="' . route('admin.administrators.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2"><i class="far fa-edit"></i></a>';
                        }
                    }
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
    public function salesPerson(){
        $role      = Role::find(6);
        $users     = User::role($role->name)->latest()->paginate(100);
        $this->data['users'] = $users;
        return view('admin.salesperson.index', $this->data);
    }
    public function salesPersonCreate(){
        return view('admin.salesperson.create', $this->data);
    }
    public function salesPersonDemo(){
        return view('admin.iframe.index', $this->data);
    }
    public function salesPersonMyAccount(){
        $user =  Auth::user();
        $shops = Shop::where('salesperson', $user->id)->get();
        $rank = Rank::all();
        $scale = Scale::all();
        return view('admin.salesperson.myacount', compact('shops','rank','scale','user'));
    }
    public function salesPersonBasket($shop_id){

        $order_id = Order::where('shop_id', '=',$shop_id)->pluck('id');
        $orders = OrderLineItem::whereIn('order_id',$order_id)->get();
        return view('admin.salesperson.viewbasket', compact('orders'));
    }
    public function salesPersonStore(Request $request){

        $user             = new User;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username ?? $this->username($request->email);
        $user->password   = Hash::make(request('password'));
        $user->phone      = $request->phone;
        $user->address    = $request->address;
        $user->status     = $request->status;

        $user->p3 = 1;

        $user->p1 = 0;
        $user->p2 = 0;
        $user->p4 = 0;
        $user->p5 = 0;
        $user->p6 = 0;
        $user->p7 = 0;
        $user->p8 = 0;
        $user->p9  = 0;
        $user->p10  = 0;
        $user->p11  = 0;
        $user->p12  = 0;

        if($user->save()){
            $response = Http::post('https://demo.yummybox.fr/api/v2/sales/person/store', [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email ,
                'phone' => $user->phone ,
                'username' => $user->username ,
                'password' => $request->password,
                'status' => $user->status,
                'address' => $user->address,

            ]);

        }

        if (request()->file('image')) {
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(6);
        $user->assignRole($role->name);

        return redirect(route('admin.sales.person'))->withSuccess('The Data Inserted Successfully');

    }
    public function salesPersonDashboard(){
        $mysettings =  Mysettings::find(1);
        return view('admin.mysettings.index', compact('mysettings'));
    }
    public function salesPersonDashboardStore(Request $request){
        $mysettings =  Mysettings::find(1);
        $mysettings->description = $request->description;
        $mysettings->update();
        return redirect()->back()->withSuccess('The Data Updates Successfully');
    }
    public function salesPersonStatus(){
        $rank =  Rank::paginate(10);
        return view('admin.mysettings.rank', compact('rank'));
    }
    public function salesPersonStatusCreate(){
        return view('admin.mysettings.rankcreate');
    }
    public function salesPersonStatusStore(Request $request){
        $rank = new Rank();
        $rank->name = $request->name;
        $rank->color = $request->color;
        $rank->save();
        return redirect()->back()->withSuccess('The Data Inserted Successfully');
    }
    public function salesPersonStatusEdit($id){
        $rank= Rank::find($id);
        return view('admin.mysettings.rankupdate',compact('rank'));
    }
    public function salesPersonStatusUpdate(Request $request,$id){
        $rank= Rank::find($id);
        $rank->name = $request->name;
        $rank->color = $request->color;
        $rank->update();
        return redirect()->back()->withSuccess('The Data Updates Successfully');
    }
    public function salesPersonScaleStatus($id){
        $scale =  Scale::where('rank_id','=',$id)->paginate(10);
        return view('admin.mysettings.scale.index', compact('scale'));
    }
    public function salesPersonScale(){
        $scale =  Scale::paginate(10);
        return view('admin.mysettings.scale.index', compact('scale'));
    }
    public function salesPersonScaleCreate(){
        $rank = Rank::all();
        return view('admin.mysettings.scale.create',compact('rank'));
    }
    public function salesPersonScaleStore(Request $request){
        $scale = new Scale();
        $scale->title = $request->title;
        $scale->rank_id = $request->rank_id;
        $scale->save();
        return redirect()->back()->withSuccess('The Data Inserted Successfully');
    }
    public function salesPersonScaleEdit($id){
        $scale= Scale::find($id);
        $rank = Rank::all();
        return view('admin.mysettings.scale.edit',compact('scale','rank'));
    }
    public function salesPersonScaleUpdate(Request $request,$id){

        $scale= Scale::find($id);
        $scale->title = $request->title;
        $scale->rank_id = $request->rank_id;

        $scale->update();
        return redirect()->back()->withSuccess('The Data Updates Successfully');
    }
    public function documentIndexSalePerson(){
        $role      = Role::find(6);
        $users     = User::role($role->name)->latest()->get();
        $doc = Documents::where('user_id','=','all')->orwhere('user_id','=',Auth::user()->id)->latest()->paginate(10);

        return view('admin.doc.index',compact('doc','users'));
    }
    public function documentIndexAdmin(){
        $role      = Role::find(6);
        $users     = User::role($role->name)->latest()->get();
        $doc = Documents::Where('user_id','=','admin')->latest()->paginate(10);

        return view('admin.doc.index',compact('doc','users'));
    }
    public function documentStore(Request $request){

         $doc = new Documents();

        $doc->sender_id = Auth::user()->id;

         if($request->admin){
             $doc->user_id = "admin";
         }
         else{
             $doc->user_id = $request->user_id;
         }


        if ($request->hasfile('file')) {
            $image1 = $request->file('file');
            $name = time() . 'file' . '.' . $image1->getClientOriginalExtension();
            $destinationPath = 'file/';
            $image1->move($destinationPath, $name);
            $doc->file = 'file/' . $name;

        }

        $doc->save();
        return redirect()->back()->withSuccess('Your Document Send Successfully');
    }
    public function documentDelete($id){

        $doc = Documents::Where('id','=',$id)->first();

        $doc->delete();

        return redirect()->back()->withError('Your Document Deleted Successfully');
    }
}
