<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Suggest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Session;
class ContactController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Contact Us';
    }

    public function __invoke()
    {
        return view('contact', $this->data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [ 'name' => 'required', 'email' => 'required|email', 'message' => 'required' ]);



        try {

            Mail::send('email.email',
                array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'user_message' => $request->get('message')
                ), function($message) use ($request)
                {
                    $message->from($request->get('email'));
                    $message->to(setting('site_email'), 'Admin');
                });

        } catch (\Exception $exception) {
            return back()->with('error', 'Mail Not Sent');
        }

        return back()->with('success', 'Thanks for contacting us!');
    }
    public function faq(){
        $this->data['user'] = auth()->user();

        $this->data['namepage']  = 'FAQ';

        return view('frontend.faq',  $this->data);
    }
    public function how_it_works(){
        $this->data['user'] = auth()->user();

        $this->data['namepage']  = 'Comment ça marche';

        return view('frontend.intro.1',  $this->data);
    }
    public function sponsership(){
        $this->data['user'] = auth()->user();

        $this->data['namepage']  = 'Parrainage';

        return view('frontend.sponsership',  $this->data);
    }
    public function suggest(){
        $this->data['user'] = auth()->user();

        $this->data['namepage']  = 'Suggérer un commerce';

        return view('frontend.suggest',  $this->data);
    }
    public function suggeststore(Request $request){
        $suggest = new Suggest();
        $suggest->name = $request->name;
        $suggest->type = $request->type;
        $suggest->postal = $request->postal;
        $suggest->address = $request->address;
        $suggest->phone = $request->phone;
        $suggest->email = $request->email;
        $suggest->category = $request->category;
        $suggest->user_id = Auth::user()->id;
        $suggest->save();
        Session::flash('message', 'Vos coordonnées ont été soumises avec succès');
        return redirect()->back();
    }
}
