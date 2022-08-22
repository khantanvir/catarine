<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Redlep;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
//use Auth;
use Session;
use App\Models\User;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use App\Models\MoreImage;
use DB;
use Image;
use Illuminate\Support\Facades\File;
use App\Models\FoodFeedback;

class CatarineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "admin") {
            return redirect('/');
        }
        $data['page_title'] = 'Create Catarine';
        $data['catarine'] = True;
        $data['create_catarine_user'] = True;
        return view('catarine/create_catarine_user',$data);
    }
    //all food for catarine prople
    public function all_catarine_food(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $data['all'] = Product::where('catarine_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        $data['page_title'] = 'All Catarine Food';
        $data['product_catarine'] = True;
        $data['all_catarine_food'] = True;
        return view('catarine/all_catarine_food',$data);
    }
    //edit catarine food
    public function edit_catarine_food($url=NULL){
        if(empty($url)){
            return redirect('/');
        }
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $data['product'] = Product::where('url',$url)->where('catarine_id',Auth::user()->id)->first();
        if(empty($data['product'])){
            Session::flash('success', 'Food Data not found!');
            return redirect('all-catarine-food');
        }
        $data['all_catarine_food'] = True;
        return view('catarine/edit_catarine_food',$data);
    }
    //edit product by catarine post
    public function edit_product_by_catarine_post(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $rules=[
            'title'=>['required', 'required:products,title','max:200'],
            'description'=>['required', 'required:products,description'],
            'catarine_price'=>['required', 'required:products,catarine_price'],
            'selling_price'=>['required', 'required:products,selling_price'],
            'discount'=>['required', 'required:products,discount'],
            'after_discount_price'=>['required', 'required:products,after_discount_price'],
            'product_type'=>['required', 'required:products,product_type'],

        ];
        $messages = array(
            'title.required' => 'Title is required.',
            'title.max' => 'Title charecter not more than 200.',
            'description.required' => 'Description is required.',
            'catarine_price.required' => 'Catarine Price is required.',
            'selling_price.required' => 'Selling Price is required.',
            'discount.required' => 'Discount is required.',
            'product_type.required' => 'Product Type is required.',
            'after_discount_price.required' => 'After Discount Price is required.',
            'delivery_cost.required' => 'Delivery Cost is required.',

        );
        $valid = Validator::make($request->input(), $rules, $messages);
        if($valid->fails()){
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        }else{
            $product = Product::where('id',$request->input('id'))->where('catarine_id',Auth::user()->id)->first();
            if(empty($product)){
                Session::flash('error', 'Catarine Product Data Not Found');
                return redirect('all-catarine-food');
            }

            $product->title = $request->input('title');
            $product->description = $request->input('description');
            $product->catarine_price = $request->input('catarine_price');
            $product->selling_price = $request->input('selling_price');
            $product->discount = $request->input('discount');
            $product->after_discount_price = $request->input('after_discount_price');
            $product->delivery_cost = $request->input('delivery_cost');
            $product->product_type = $request->input('product_type');
            $product->catarine_id = Auth::user()->id;

            $product->save();

            Session::flash('success', 'Catarine Product Updated Successfully');
            return redirect('all-catarine-food');
        }
    }
    public function post_catarine_user_data(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "admin") {
            return redirect('/');
        }
        $rules=[
            'company_name'=>['required', 'required:users,name','max:200'],
            'city2'=>['required', 'required:users,address'],
            'cityLat'=>['required', 'required:users,latitude'],
            'cityLng'=>['required', 'required:users,longitude'],
            'contact_first_name'=>['required', 'required:users,first_name'],
            'contact_last_name'=>['required', 'required:users,last_name'],
            'email'=>['required', 'unique:users,email', 'max:64'],
            'password'=>['required', 'required:users,password','min:6','max:25'],
            'confirm_password'=>['required','same:password'],
        ];
        $messages = array(
            'company_name.required' => 'Company Name is required.',
            'city2.required' => 'Company Address is required.',
            'cityLat.required' => 'Please write down correct address from GEO location.',
            'cityLng.required' => 'Please write down correct GEO location.',

            'contact_first_name.required' => 'Contact Person First Name is Required',
            'contact_last_name.required' => 'Contact Person Last Name is required.',
            'email.required' => 'Email or Phone is Required',
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
            $pisqr = new Redlep();
            $users = new User();
            $users->name = $request->input('company_name');
            $users->address = $request->input('city2');
            $users->latitude = $request->input('cityLat');
            $users->longitude = $request->input('cityLng');
            $users->zip_code = $request->input('zip_code');
            $users->first_name = $request->input('contact_first_name');
            $users->last_name = $request->input('contact_last_name');
            $users->alt_contact = $request->input('alt_number');
            $users->website = $request->input('website');
            $users->role = "catarine";

            $url_modify = $pisqr->slug_create($users->name);
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
            $users->remember_token = $pisqr->randomRemebberToken();
            $users->is_deleted = 0;
            $users->active = 0;
            $users->save();
            Session::flash('success', 'Catarine Data Saved Successfully');
            return redirect('all-catarine-users');
        }
    }
    public function all_catarine_users(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "admin") {
            return redirect('/');
        }
        $data['all'] = User::orderBy('id','desc')->where('role','catarine')->paginate(5);
        $data['page_title'] = 'Alla katarinanvändare';
        $data['catarine'] = True;
        $data['all_catarine_user'] = True;
        return view('catarine/all_catarine_user',$data);
    }
    //catarine details function
    public function catarine_details($url=NULL){
        if(empty($url)){
            return redirect('/');
        }
        $data['details'] = User::where('url',$url)->where('role','catarine')->first();
        if(empty($data['details'])){
            return redirect('search-catarine');
        }
        $data['foods'] = Product::where('catarine_id',$data['details']->id)->where('status',0)->where('is_deleted',0)->where('product_type',1)->paginate(12);
        $data['specials'] = Product::where('catarine_id',$data['details']->id)->where('status',0)->where('is_deleted',0)->where('product_type',2)->get();
        $data['salads'] = Product::where('catarine_id',$data['details']->id)->where('status',0)->where('is_deleted',0)->where('product_type',3)->get();
        $data['page_title'] = 'Catarine Detaljer';
        return view('catarine/catarine_details',$data);
    }
    //catarine product details code
    public function catarine_product_details($url=NULL){
        if(empty($url)){
            return redirect('/');
        }
        $data['details'] = Product::where('url',$url)->where('status',0)->where('is_deleted',0)->first();
        if(empty($data['details'])) {
            return redirect('/');
        }
        $countMsg=0;
        $data['related'] = Product::where('catarine_id',$data['details']->catarine_id)->where('status',0)->where('is_deleted',0)->inRandomOrder()->take(4)->get();
        $data['more_images'] = MoreImage::where('product_id',$data['details']->id)->get();
        $data['catarine'] = User::where('id',$data['details']->catarine_id)->first();
        $data['feedbacks'] = FoodFeedback::where('product_id',$data['details']->id)->orderBy('id','desc')->get();
        if(!empty($data['feedbacks'])){
            foreach($data['feedbacks'] as $row){
                $countMsg += $row->rating;
            }
        }
        if($countMsg != 0){
            $result = $countMsg / count($data['feedbacks']);
            $data['msg_count'] = round($result);
        }else{
            $data['msg_count'] = 0;
        }
        $data['page_title'] = 'Catarine produktdetaljer';
        return view('catarine/catarine_product_details',$data);
    }
    //search catarine code
    public function search_catarine($lat=NULL,$lon=NULL){

        $latitude = 59.2756729;
        $longitude = 17.9079075;
        if(!empty($lat) && !empty($lon) && is_numeric($lat) && is_numeric($lon)){
            Session::put('latitude',$lat);
            Session::put('longitude',$lon);
        }
        if(!empty(Session::get('latitude')) && !empty(Session::get('longitude'))){
            $latitude = Session::get('latitude');
            $longitude = Session::get('longitude');
        }
        if(empty(Session::get('latitude')) && empty(Session::get('longitude')) && !empty($_COOKIE['latitude']) && !empty($_COOKIE['longitude'])){
            $latitude = $_COOKIE['latitude'];
            $longitude= $_COOKIE['longitude'];
        }
        $data['latitude_p'] = $latitude;
        $data['longitude_p'] = $longitude;
        $query = $this->getByDistance($data['latitude_p'],$data['longitude_p'],6);
        if(empty($query)){
            $data['data_result'] = 'Catarine Address Not Found In your Area. You can order food nearest 7 km radius of catarine!';
        }
        $ids = [];
        foreach($query as $q)
        {
            array_push($ids, $q->id);
        }
        $ids_ordered = implode(',',$ids);
        $data['users'] = DB::table('users')->where('role','catarine')->whereIn('id', $ids)->orderByRaw(DB::raw("FIELD(id, $ids_ordered)"))->paginate(1);
        $data['page_title'] = 'Catarine Search by your location';
        $data['search_current'] = true;
        return view('catarine/search_catarine',$data);
    }
    //this function is for chnage catarine main image
    public function create_main_image(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $data['catarine_home'] = True;
        $data['create_main_image'] = True;
        return view('catarine/create_main_image_by_catarine',$data);
    }
    //post main image by catarine
    public function create_main_image_post(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $user = User::find(Auth::user()->id);
        $image = $request->file('main_image');
        if($request->hasFile('main_image')){
            if(!empty($user->main_image)){
                $updateFileName = base_path().'/public/catarine/main/'.$user->main_image;
                if(File::exists($updateFileName)){
                    File::delete($updateFileName);
                }
            }
            $ext = $image->getClientOriginalExtension();
            $filename = $image->getClientOriginalName();
            $filename = rand(1000,100000).'.'.$ext;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(200,200);
            $image_resize->save(public_path('catarine/main/' .$filename));
            $user->main_image = $filename;
            $user->save();
            Session::flash('success', 'Main Image Uploaded Successfully.');
            return redirect('create-main-image');
        }else{
            Session::flash('error', 'You did,t select any image:)');
            return redirect('create-main-image');
        }
    }
    //this function is for chnage catarine cover image
    public function create_cover_image(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $data['catarine_home'] = True;
        $data['create_cover_image'] = True;
        return view('catarine/create_cover_image_by_catarine',$data);
    }
    public function create_cover_image_post(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $user = User::find(Auth::user()->id);
        $image = $request->file('cover_image');
        if($request->hasFile('cover_image')){
            if(!empty($user->cover_image)){
                $updateFileName = base_path().'/public/catarine/cover/'.$user->cover_image;
                if(File::exists($updateFileName)){
                    File::delete($updateFileName);
                }
            }
            $ext = $image->getClientOriginalExtension();
            $filename = $image->getClientOriginalName();
            $filename = rand(1000,100000).'.'.$ext;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(900,480);
            $image_resize->save(public_path('catarine/cover/' .$filename));
            $user->cover_image = $filename;
            $user->save();
            Session::flash('success', 'Cover Image Uploaded Successfully.');
            return redirect('create-cover-image');
        }else{
            Session::flash('error', 'You did,t select any image:)');
            return redirect('create-cover-image');
        }
    }
    //chage catarine profile information
    public function change_catarine_profile_info(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $data['profile'] = User::find(Auth::user()->id);
        $data['catarine_home'] = True;
        $data['change_catarine_profile_info'] = True;
        return view('catarine/change_catarine_profile_info',$data);
    }
    //post catarine profile data update
    public function change_catarine_profile_info_post(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $user = User::find(Auth::user()->id);
        if(!empty($request->input('company_name'))){
            $user->name = $request->input('company_name');
        }
        if(!empty($request->input('zip_code'))){
            $user->zip_code = $request->input('zip_code');
        }
        if(!empty($request->input('phone'))){
            $user->phone = $request->input('phone');
        }
        if(!empty($request->input('contact_first_name'))){
            $user->first_name = $request->input('contact_first_name');
        }
        if(!empty($request->input('contact_last_name'))){
            $user->last_name = $request->input('contact_last_name');
        }
        if(!empty($request->input('website'))){
            $user->website = $request->input('website');
        }
        if(!empty($request->input('bio'))){
            $user->bio = $request->input('bio');
        }
        if(!empty($request->input('main_items'))){
            $user->main_items = $request->input('main_items');
        }

        if(!empty($request->input('experience'))){
            $user->experience = $request->input('experience');
        }
        if(!empty($request->input('short_bio'))){
            $user->short_bio = $request->input('short_bio');
        }
        if(!empty($request->input('delivery_time'))){
            $user->delivery_time = $request->input('delivery_time');
        }
        if(!empty($request->input('city2')) && !empty($request->input('cityLat')) && !empty($request->input('cityLng'))){
            $user->address = $request->input('city2');
            $user->latitude = $request->input('cityLat');
            $user->longitude = $request->input('cityLng');
        }
        $user->save();
        Session::flash('success', 'Catarine Profile Data Updated Successfully.');
        return redirect('change-catarine-profile-info');
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

    public function getByDistance($lat, $lng, $distance)
    {
        $results = DB::select(DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $lng . ') ) + sin( radians(' . $lat .') ) * sin( radians(latitude) ) ) ) AS distance FROM users HAVING distance < ' . $distance . ' ORDER BY distance ASC') );
        return $results;
    }
}
