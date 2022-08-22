<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Redlep;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;
use Auth;
use Session;
use URL;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\UserDetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $data['page_title'] = 'Hem';
        $data['home_current'] = true;
        return view('home/index',$data);
    }
    public function login(){
        $data['page_title'] = 'Logga in';
        $data['login_current'] = true;
        return view('home/login',$data);
    }

    public function custom_login(Request $request){
        try{
            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
            {
                if(Auth::user()->active==1) {
                    Auth::logout();
                    Session::flash('error', 'Ditt konto är inaktivt. Ring till administratören och aktiv igen!');
                    return Redirect::back();
                }
                $getUserRole = Auth::user()->role;
                if(!empty($getUserRole)){
                    Session::put('user_role',$getUserRole);
                }else{
                    Auth::logout();
                    Session::forget('user_role');
                    Session::flash('error', 'Du har inte någon roll just nu ring till administratören försök igen:)');
                    return redirect('user-login');
                }
                if(Session::get('user_role')=='admin'){
                    return redirect('dashboard');
                }elseif(Session::get('user_role')=='catarine'){
                    return redirect('create-main-image');
                }elseif(Session::get('user_role')=='users'){
                    $getUrl = Session::get('current_url');
                    if(!empty($getUrl)){
                        return redirect($getUrl);
                    }
                    return redirect('/');

                }else{
                    Auth::logout();
                    Session::forget('user_role');
                    Session::flash('error', 'Du har inte någon roll just nu ring till administratören försök igen:)');
                    return redirect('user-login');
                }
                try{
                    Session::forget('error');
                    return redirect('dashboard');
                } catch(\Exception $e){
                    return Session::flash('error', 'Oj, något är fel! Kan inte logga in!');
                    return Redirect::back();
                }

            }
            else {
                Session::flash('error', 'E-post och lösenord stämmer inte!');
                return Redirect::back();
            }
        } catch(\Exception $e){
            Session::flash('error', 'Oj, något är fel! Kan inte logga in!');
//            return $e->getMessage();
            return Redirect::back();
        }
    }
    //user register page
    public function register(){
        $data['page_title'] = 'Registrera';
        $data['login_current'] = true;
        return view('home/register',$data);
    }
    //terms and condition page
    public function terms_condition(){
        $data['page_title'] = 'Villkor & Villkor';
        return view('home/terms',$data);
    }
    //user register process code
    public function user_ragistration_process(Request $request){
        $rules=[
            'first_name'=>['required', 'required:users,first_name','max:30'],
            'last_name'=>['required', 'required:users,last_name','max:30'],
            'email'=>['required', 'unique:users,email', 'max:64'],
            'password'=>['required', 'required:users,password','min:6','max:25'],
            'confirm_password'=>['required','same:password'],
        ];
        $messages = array(
            'first_name.required' => 'Förnamn krävs.',
            'first_name.max' => 'Förnamnets charterfält högst 30.',
            'last_name.required' => 'Efternamn krävs.',
            'last_name.max' => 'Efternamn för charternamn högst 30.',
            'email.required' => 'E-postfält krävs.',
            'password.required' => 'Lösenordsfält krävs.',
            'password.min' => 'Lösenordet måste vara 6 tecken långt.',
            'password.max' => 'Lösenordstecken högst 25.',
            'confirm_password.required' => 'Bekräfta lösenordsfältet krävs.',
            'confirm_password.same' => 'Fältet Lösenord och bekräfta lösenord måste vara samma',
            'email.unique' => $request->input('email').' E-post finns redan!'
        );
        $valid = Validator::make($request->input(), $rules, $messages);
        if($valid->fails()){
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        }else{
            $redlep = new Redlep();
            $users = new User();
            $users->first_name = $request->input('first_name');
            $users->last_name = $request->input('last_name');
            $users->name = $users->first_name.' '.$users->last_name;
            $url_modify = $redlep->slug_create($users->name);
            $checkSlug = User::where('url', 'LIKE', '%' . $url_modify . '%')->count();
            if ($checkSlug > 0) {
                $new_number = $checkSlug + 1;
                $new_slug = $url_modify . '-' . $new_number;
                $users->url = $new_slug;
            } else {
                $users->url = $url_modify;
            }
            $users->email = $request->input('email');
            $users->password = Hash::make($request->input('password'));
            $users->remember_token = $redlep->randomRemebberToken();
            $users->role = "users";
            $users->is_deleted = 0;
            $users->active = 0;
            $users->save();
            try{
                if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
                {
                    if(Auth::user()->active==1) {
                        Auth::logout();
                        Session::flash('error', 'Ditt konto är inaktivt. Ring till administratören och aktiv igen!');
                        return Redirect::back();
                    }
                    $getUserRole = Auth::user()->role;
                    if(!empty($getUserRole)){
                        Session::put('user_role',$getUserRole);
                    }else{
                        Auth::logout();
                        Session::forget('user_role');
                        Session::flash('error', 'Du har inte någon roll just nu ring till administratören försök igen:)');
                        return redirect('user-login');
                    }
                    if(Session::get('user_role')=='users'){
                        return redirect('/');
                    }else{
                        Auth::logout();
                        Session::forget('user_role');
                        Session::flash('error', 'Du har inte någon roll just nu ring till administratören försök igen:)');
                        return redirect('user-login');
                    }

                }
                else {
                    Session::flash('error', 'E-post och lösenord stämmer inte!');
                    return Redirect::back();
                }
            } catch(\Exception $e){
                Session::flash('error', 'Oj, något är fel! Kan inte logga in!');
//            return $e->getMessage();
                return Redirect::back();
            }
        }
    }
    //profile info
    public function profile(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        $data['profile'] = User::where('id',Auth::user()->id)->first();
        $data['user_detail'] = UserDetail::where('user_id',Auth::user()->id)->first();
        $data['orders'] = Order::where('order_by',Auth::user()->id)->orderBy('id','desc')->paginate(5);
        $data['page_title'] = "Min profil";

        $data['nav_link'] = 'order';
        $data['profile_current'] = true;
        Session::forget('update_basic');
        return view('home/profile',$data);
    }
    //this code is for order details function
    public function order_details($url=NULL){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(empty($url)){
            Session::flash('error','Fakturanummer hittades inte. internt serverfel!');
            return redirect('profile');
        }
        $data['order'] = Order::where('url',$url)->where('order_by',Auth::user()->id)->first();
        if(empty($data['order'])){
            Session::flash('error','Du har inte någon tillåtelse att se denna faktura!');
            return redirect('profile');
        }
        $data['order_products'] = OrderProduct::where('order_id',$data['order']->id)->get();
        $data['billing'] = Billing::where('order_id',$data['order']->id)->where('user_id',Auth::user()->id)->first();
        $data['catarine'] = User::where('id',$data['order_products'][0]->vendor_id)->first();
        $data['profile_current'] = true;
        return view('home/order_details',$data);
    }
    //update user personal info
    public function update_profle_info(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        $user = User::find(Auth::user()->id);
        if(!empty($request->input('first_name'))){
            $user->first_name = $request->input('first_name');
        }
        if(!empty($request->input('last_name'))){
            $user->last_name = $request->input('last_name');
        }
        if(!empty($request->input('phone'))){
            $user->phone = $request->input('phone');
        }
        if(!empty($request->input('address'))){
            $user->address = $request->input('address');
        }
        if(!empty($request->input('first_name')) && !empty($request->input('last_name'))){
            $user->name = $request->input('first_name').' '.$request->input('last_name');
        }
        $user->save();

        $userDetail = UserDetail::where('user_id',Auth::user()->id)->first();
        if(!empty($request->input('s_first_name'))){
            $userDetail->first_name = $request->input('s_first_name');
        }

        if(!empty($request->input('s_last_name'))){
            $userDetail->last_name = $request->input('s_last_name');
        }
        if(!empty($request->input('s_email'))){
            $userDetail->email = $request->input('s_email');
        }
        if(!empty($request->input('s_address'))){
            $userDetail->address = $request->input('s_address');
        }
        if(!empty($request->input('s_phone'))){
            $userDetail->phone = $request->input('s_phone');
        }
        if(!empty($request->input('s_apartment'))){
            $userDetail->apartment = $request->input('s_apartment');
        }
        if(!empty($request->input('s_city'))){
            $userDetail->city = $request->input('s_city');
        }
        if(!empty($request->input('s_post_code'))){
            $userDetail->post_code = $request->input('s_post_code');
        }
        $userDetail->save();
        Session::flash('nav_menu','active');
        Session::flash('success', 'Användarens grundläggande informationsdata uppdaterades framgångsrikt!');
        return redirect('profile');
    }
    //password change store
    public function change_password_store(Request $request){
        if(Auth::check()){
            if($request->input('new_password') == $request->input('retype_password')){
                try{
                    if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->input('current_password')]))
                    {
                        try{
                            $user = User::find(Auth::user()->id);
                            $user->password = Hash::make($request->input('new_password'));
                            if($user->save()){
                                Session::flash('nav_menu1','active');
                                Session::flash('success', 'lösenordet har ändrats!');
                                return redirect('profile');
                            }
                        } catch(\Exception $e){
                            Session::flash('success', 'Nuvarande lösenord matchar inte!');
                            return redirect('profile');
                        }

                    } else {
                        Session::flash('error', 'Nuvarande lösenord matchar inte!');
                        return redirect('profile');
                    }
                } catch(\Exception $e){
                    Session::flash('success', 'Nuvarande lösenord matchar inte!');
                    return redirect('profile');
                }
            } else {
                Session::flash('success', 'Nytt lösenord och lösenord för ny typ stämmer inte!');
                return redirect('profile');
            }
        } else {
            Session::flash('error', 'Logga in först Sedan ändra lösenord!');
            return redirect('profile');
        }
    }
    //user signout code
    public function signout(){
        Auth::logout();
        Session::forget('user_role');
        Session::flash('success', 'Ut loggad!');
        return redirect('user-login');
    }
    //counact us code
    public function contact_us(){
        $data['page_title'] = 'Kontakta oss';
        $data['contact_current'] = true;
        return view('home/contact_us',$data);
    }
    //contact us post data
    public function contact_us_post_data(Request $request){
        $rules=[
            'name'=>['required', 'required:contact_us,name','max:30'],
            'email'=>['required', 'required:contact_us,email','max:60'],
            'subject'=>['required', 'required:contact_us,subject'],
            'message'=>['required', 'required:contact_us,message'],
        ];
        $messages = array(
            'name.required' => 'Namn krävs.',
            'first_name.max' => 'Namn charterfältet inte mer än 30.',
            'email.required' => 'E-post eller telefonnummer krävs.',
            'email.max' => 'E-post / telefon charterfält inte mer än 60.',
            'subject.required' => 'Ämnesfält krävs.',
            'message.required' => 'Meddelande krävs.'
        );
        $valid = Validator::make($request->input(), $rules, $messages);
        if($valid->fails()){
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        }else{
            $contact = new Contact();
            $contact->name = $request->input('name');
            $contact->email = $request->input('email');
            $contact->subject = $request->input('subject');
            $contact->message = $request->input('message');
            $contact->save();
            Session::flash('success', 'Tack för att du kontaktar oss. Vi kommer snart att kontakta dig :)');
            return redirect('contact-us');
        }
    }

}
