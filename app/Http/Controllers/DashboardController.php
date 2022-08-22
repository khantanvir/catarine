<?php

namespace App\Http\Controllers;

use App\Models\Redlep;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;
use Auth;
use Session;
use URL;
use App\Models\Exam;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role=="admin") {
            $data['page_title'] = 'Dashboard';
            $data['dashboard'] = True;
            $data['dashboard_page'] = True;
            return view('dashboard/index', $data);
        }
    }
    public function create_user(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role=="admin") {
            $data['page_title'] = 'Dashboard';
            $data['dashboard'] = True;
            $data['create_user'] = True;
            return view('dashboard/create_user', $data);
        }
    }
    public function post_user_data(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "admin") {
            return redirect('/');
        }
        $rules=[
            'first_name'=>['required', 'required:users,first_name','max:30'],
            'last_name'=>['required', 'required:users,last_name','max:30'],
            'city2'=>['required', 'required:users,address'],
            'cityLat'=>['required', 'required:users,latitude'],
            'cityLng'=>['required', 'required:users,longitude'],
            'phone'=>['required', 'required:users,phone'],
            'email'=>['required', 'unique:users,email', 'max:64'],
            'password'=>['required', 'required:users,password','min:6','max:25'],
            'confirm_password'=>['required','same:password'],
        ];
        $messages = array(
            'first_name.required' => 'First Name is required.',
            'first_name.max' => 'First Name charecter field not more than 30.',
            'last_name.required' => 'Last Name is required.',
            'city2.required' => 'Geo Address is required for registration.',
            'cityLat.required' => 'Please write down correct address from GEO location.',
            'cityLng.required' => 'Please write down correct GEO location.',
            'last_name.max' => 'Last Name charecter field not more than 30.',
            'password.required' => 'Password field is required.',
            'password.min' => 'Password must be 6 charecter long.',
            'password.max' => 'Password charecter not more than 25.',
            'confirm_password.required' => 'Confirm Password field is required.',
            'confirm_password.same' => 'Password and Confirm password field must be same',
            'email.unique' => $request->input('email').' Email/Phone Already Exists!'
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
            $users->address = $request->input('city2');
            $users->latitude = $request->input('cityLat');
            $users->longitude = $request->input('cityLng');
            $users->city = $request->input('city');


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
            $users->phone = $request->input('phone');
            $users->password = Hash::make($request->input('password'));
            $users->remember_token = $redlep->randomRemebberToken();
            $users->role = "delivery";
            $users->is_deleted = 0;
            $users->active = 0;
            $users->save();
            Session::flash('success', 'Delivery User Create Successfully');
            return redirect('all-users');
        }
    }
    public function all_users(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "admin") {
            return redirect('/');
        }
        $data['all'] = User::orderBy('id','desc')->where('role','delivery')->paginate(5);
        $data['page_title'] = 'Dashboard';
        $data['dashboard'] = True;
        $data['all_user'] = True;
        return view('dashboard/all_user',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
