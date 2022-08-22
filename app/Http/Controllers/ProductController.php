<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Redlep;

use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;
use Validator;
//use Auth;
use Session;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Requests;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Hash;
use DB;
use Image;
use URL;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\MoreImage;
use App\Models\FoodFeedback;
use App\Models\UserDetail;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\Billing;


class ProductController extends Controller
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

    }
    //this code is for catarine upload product
    public function create_product_by_catarine(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $data['page_title'] = 'Create Product';
        $data['product_catarine'] = True;
        $data['create_product_by_catarine'] = True;
        return view('product/create_product_by_catarine',$data);
    }
    //this code is for product discount
    public function get_discount(Request $request){
        $pisqr = new Redlep();
        $sellingPrice = $request->input('selling_price');
        $discount = $request->input('discount');
        if(!empty($sellingPrice)){
            if(is_numeric($sellingPrice) && is_numeric($discount)){
                $getDiscountRate = $pisqr->getDiscount($discount,$sellingPrice);
                $afterDiscountRate = $sellingPrice - $getDiscountRate;
                $data['result'] = array(
                    'key' =>200,
                    'val' => $afterDiscountRate
                );
            }else{
                $data['result'] = array(
                    'key' =>101,
                    'val' => 'Selling or Discount price must be number! '
                );
            }
        }else{
            $data['result'] = array(
                'key' =>102,
                'val' => 'Data not found'
            );
        }
        return response()->json($data,200);
    }
    //this code is for add product item
    public function create_product_by_catarine_post(Request $request){
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
            $pisqr = new Redlep();
            $product = new Product();
            //image upload check
            if(!$request->hasFile('more_images')){
                Session::flash('error', 'You select at least one image:)');
                return redirect('create-product-by-catarine');
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

            $url_modify = $pisqr->slug_create($product->title);
            $checkSlug = Product::where('url', 'LIKE', '%' . $url_modify . '%')->count();
            if ($checkSlug > 0) {
                $new_number = $checkSlug + 1;
                $new_slug = $url_modify . '-' . $new_number;
                $product->url = $new_slug;
            } else {
                $product->url = $url_modify;
            }
            //main image upload code
            $image = $request->file('main_image');
            if($request->hasFile('main_image')){
                $ext = $image->getClientOriginalExtension();
                $filename = $image->getClientOriginalName();
                $filename = rand(1000,100000).'.'.$ext;
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(234,234);
                $image_resize->save(public_path('products/main_image/' .$filename));
                $product->main_image = $filename;
            }else{
                Session::flash('error', 'You did,t select any main image:)');
                return redirect('create-product-by-catarine');
            }
            $product->save();
            //more image upload code
            $images = $request->file('more_images');
            foreach($images as $row){
                $more_image = new MoreImage();
                if($request->hasFile('more_images')){
                    $ext = $row->getClientOriginalExtension();
                    $filename = $row->getClientOriginalName();
                    $filename = rand(1000,100000).'.'.$ext;
                    $image_resize = Image::make($row->getRealPath());
                    $image_resize->resize(600,600);
                    $image_resize->save(public_path('products/more_images/' .$filename));
                    $more_image->image = $filename;
                    $more_image->product_id = $product->id;
                    $more_image->save();
                }else{
                    Session::flash('error', 'You select at least one image:)');
                    return redirect('create-product-by-catarine');
                }
            }
            Session::flash('success', 'Catarine Product Upload Successfully');
            return redirect('all-catarine-food');
        }
    }
    //add to cart code
    public function add_to_cart(Request $request){
        //Session::forget('cart');
        //return;
        $quantity = $request->input('quantity');
        $product_url = $request->input('product_url');
        $check = Product::where('url',$product_url)->where('status',0)->where('is_deleted',0)->first();
        if(empty($check)){
            $data['result'] = array(
                'key' =>102,
                'val' => 'Produktdata hittades inte!'
            );
            return response()->json($data,200);
        }
        //insert first product
        $products[] = array(
            'product_id' => $check->id,
            'catarine_id' => $check->catarine_id,
            'quantity' => $quantity,
            'price' => $check->after_discount_price,
            'sub_total' => $quantity * $check->after_discount_price
        );
        $getSessionData = Session::get('cart');
        if(!empty($getSessionData)){
            $getUpdateCart = array();
            foreach($getSessionData as $row){
                if($check->catarine_id != $row['catarine_id']){
                    $data['result'] = array(
                        'key' =>101,
                        'val' => 'Slutför den aktuella katarinordningen. Välj sedan nästa katarin!'
                    );
                    return response()->json($data,200);
                }
                if($row['product_id']==$check->id){
                    $update_quantity = $row['quantity'] + $quantity;
                    $row1[] = array(
                        'product_id' => $check->id,
                        'catarine_id' => $check->catarine_id,
                        'quantity' => $update_quantity,
                        'price' => $check->after_discount_price,
                        'sub_total' => $update_quantity * $check->after_discount_price
                    );
                    $getUpdateCart = $this->update_cart($row1,$check->id);
                    Session::forget('cart');
                    Session::put('cart',$getUpdateCart);
                    $getSessionData = Session::get('cart');
                    $data['result'] = array(
                        'key' =>200,
                        'count' => count($getSessionData),
                        'val' => $this->get_cart_data()
                    );
                    return response()->json($data,200);
                }
            }
            $m = array_merge($getSessionData,$products);
            Session::forget('cart');
            Session::put('cart',$m);
            $data['result'] = array(
                'key' =>200,
                'count' => count(Session::get('cart')),
                'val' => $this->get_cart_data()
            );
            return response()->json($data,200);
        }else{
            Session::forget('cart');
            Session::put('cart',$products);
        }
        $getSessionData = Session::get('cart');
        $data['result'] = array(
            'key' =>200,
            'count' => count($getSessionData),
            'val' => $this->get_cart_data()
        );
        return response()->json($data,200);

    }
    public function update_cart($arr=array(),$id){
        if(!empty($arr) && !empty($id)){
            $getSessionData = Session::get('cart');
            if(!empty($getSessionData)){
                $values = array();
                foreach($getSessionData as $key => $row){
                    if($row['product_id']==$id){
                        if(false !== $key){
                            unset($getSessionData[$key]);
                        }
                    }else{
                        $values[] = $row;
                    }
                }
                $m = array_merge($values,$arr);
                return $m;
            }
        }
    }
    //get cart ajax data
    public function get_cart_data(){
        $getSessionData = Session::get('cart');
        $data = '';
        $subtotal = 0;
        if(!empty($getSessionData)){
            $data .= '<div class="top-cart-items">';
            $var = 0;
            foreach($getSessionData as $cartRow){
                $get_product = Product::where('id',$cartRow['product_id'])->first();
                $data .= '<div class="top-cart-item clearfix">';
                    $data .= '<div class="top-cart-item-image">';
                        $data .= '<a href="'.url('catarine-product-details/'.$get_product->url).'"><img src="'.url('public/products/main_image/'.$get_product->main_image).'" alt="'.$get_product->title.'" /></a>';
                    $data .= '</div>';
                    $data .= '<div class="top-cart-item-desc">';
                        $data .= '<input type="hidden" name="product_id" value="'.$cartRow['product_id'].'" id="product_id'.$var.'" >';
                        $data .= '<a href="'.url('catarine-product-details/'.$get_product->url).'">'.$get_product->title.'</a>';
                        $data .= '<span class="top-cart-item-price">'.$get_product->after_discount_price.' kr'.'<a onclick="deleteFromCart('.$var.')" style="float: right; color: red;" href="javascript://"><i class="icon-line-delete"></i></a></span>';
                        $data .= '<span class="top-cart-item-quantity">x '.$cartRow['quantity'].'</span>';
                    $data .= '</div>';
                $data .= '</div>';
                $subtotal += $cartRow['sub_total'];
                $var++;
            }
            $data .= '<div class="top-cart-action clearfix">';
                $data .= '<span class="fleft top-checkout-price">'.$subtotal.' kr'.'</span>';
                $data .= '<a href="'.url('view-cart').'" class="button button-3d button-small nomargin fright">Visa kundvagn</a>';
            $data .= '</div>';
            $data .= '</div>';

        }else{
            $data .= '<div class="top-cart-action clearfix">';
            $data .= '<span class="fleft top-checkout-price">Din vagn är tom</span>';
            $data .= '</div>';
        }
        return $data;
    }
    //this code is from delete from cart
    public function delete_from_cart(Request $request){
        $productId = $request->input('product_id');
        $check = Product::where('id',$productId)->first();
        if(!empty($check)){
            $getSessionData = Session::get('cart');
            $values = array();
            if(!empty($getSessionData)){
                foreach($getSessionData as $key => $row){
                    if($check->id == $row['product_id']){
                        unset($getSessionData[$key]);
                    }else{
                        $values[] = $row;
                    }
                }
                Session::forget('cart');
                Session::put('cart',$values);
                $getSessionData1 = Session::get('cart');
                $data['result'] = array(
                    'key' =>200,
                    'count' =>count($getSessionData1),
                    'val' => $this->get_cart_data()
                );
                return response()->json($data,200);
            }else{
                $data['result'] = array(
                    'key' =>102,
                    'val' => 'Kundvagnsdata hittades inte i detta system!'
                );
                return response()->json($data,200);
            }
        }else{
            $data['result'] = array(
                'key' =>101,
                'val' => 'Produktdata hittades inte!'
            );
            return response()->json($data,200);
        }
    }
    //this code is for food feedback and food review
    public function post_product_comment(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $rating = $request->input('rating');
        $message = $request->input('message');
        $product_url = $request->input('product_url');
        $check = Product::where('url',$product_url)->first();
        if(empty($check)){
            $data['result'] = array(
                'key' =>101,
                'val' => 'Produktdata hittades inte!'
            );
            return response()->json($data,200);
        }
        if(!empty($name) && !empty($email) && !empty($message)){
            $food = new FoodFeedback();
            $food->name = $name;
            $food->email = $email;
            $food->rating = $rating;
            $food->message = $message;
            $food->product_id = $check->id;
            $food->date = time();
            $food->save();
            $feedbacks = FoodFeedback::where('product_id',$check->id)->take(4)->get();
            $data['result'] = array(
                'key' =>200,
                'count' =>'Reviews '.count($feedbacks),
                'val' => $this->feed_back_data($check->id)
            );
            return response()->json($data,200);
        }else{
            $data['result'] = array(
                'key' =>102,
                'val' => 'Allt fält krävs'
            );
            return response()->json($data,200);
        }

    }
    //this is feedback data for product details page
    public function feed_back_data($id=NULL){
        if(empty($id)){
            return 'ID kan inte vara tom!';
        }
        $product = Product::where('id',$id)->first();
        if(empty($product)){
            return 'Produktdata hittades inte!';
        }
        $data = '';
        $feedbacks = FoodFeedback::where('product_id',$product->id)->orderBy('id','desc')->get();
        if(!empty($feedbacks)){
            $z=0;
            foreach($feedbacks as $msg){
                if($z < 3){
                $data .= '<li class="comment even thread-even depth-1" id="li-comment-1">';
                    $data .= '<div id="comment-1" class="comment-wrap clearfix">';
                        $data .= '<div class="comment-meta">';
                            $data .= '<div class="comment-author vcard">';
                                $data .= '<span class="comment-avatar clearfix">';
                                $data .= '<img alt="" src="'.url(Redlep::randomProfileImage()).'" height="60" width="60" /></span>';
                            $data .= '</div>';
                        $data .= '</div>';
                        $data .= '<div class="comment-content clearfix">';
                            $data .= '<div class="comment-author">'.$msg->name.'<span><a href="#" title="">'.date('d F Y, h:i:s A',$msg->date).'</a></span></div>';
                            $data .= '<p>'.$msg->message.'</p>';
                            $data .= '<div class="review-comment-ratings">';
                            for($i=1; $i<=5; $i++){
                                if($i <= $msg->rating){
                                    $data .= '<i class="icon-star3"></i>';
                                }else{
                                    $data .= '<i class="icon-star-empty"></i>';
                                }
                            }
                            $data .= '</div>';
                        $data .= '</div>';
                        $data .= '<div class="clear"></div>';
                    $data .= '</div>';
                $data .= '</li>';
            $z++;} }
            return $data;
        }else{
            return 'Feedbackdata hittades inte!';
        }
    }
    //this code is for view cart function
    public function view_cart(){
        $data['carts'] = Session::get('cart');
        if(empty($data['carts'])){
            Session::flash('error', 'Produktdata hittades inte!');
            return redirect('search-catarine');
        }
        if(Auth::check()){
            $data['user_info'] = User::where('id',Auth::user()->id)->first();
            $data['user_detail'] = UserDetail::where('user_id',$data['user_info']->id)->first();
        }
        $data['page_title'] = 'Visa kundvagnsprodukt';
        return view('product/view_cart',$data);
    }
    //this code is for remove product from cart
    public function remove_from_cart_page($id=NULL){
        if(empty($id)){
            return redirect('view-cart');
        }
        $check = Product::where('id',$id)->first();
        if(!empty($check)){
            $getSessionData = Session::get('cart');
            $values = array();
            if(!empty($getSessionData)){
                foreach($getSessionData as $key => $row){
                    if($check->id == $row['product_id']){
                        unset($getSessionData[$key]);
                    }else{
                        $values[] = $row;
                    }
                }
                Session::forget('cart');
                Session::put('cart',$values);
                return redirect('view-cart');
            }else{
                Session::flash('error', 'Kundvagnsdata hittades inte!');
                return redirect('view-cart');
            }
        }else{
            Session::flash('error', 'Varukorg Produktdata hittades inte!');
            return redirect('view-cart');
        }

    }
    //this function is for create order
    public function create_order(Request $request){
        if(!Auth::check()){
            $rules=[
                //this validation is for shipping address
                's_first_name'=>['required', 'required:user_details,first_name','max:40'],
                's_last_name'=>['required', 'required:user_details,last_name','max:40'],
                's_email'=>['required', 'required:user_details,email'],
                's_phone'=>['required', 'required:user_details,phone','max:30'],
                's_address'=>['required', 'required:user_details,address'],
                's_apartment'=>['required', 'required:user_details,apartment'],
                's_city'=>['required', 'required:user_details,city','max:30'],
                'datetime'=>['required', 'required:billings,datetime','max:30'],
                's_post_code'=>['required', 'required:user_details,post_code','max:30'],

            ];
            $messages = array(
                //this validation is for shipping address
                's_first_name.required' => 'Frakt Förnamn krävs.',
                's_last_name.required' => 'Frakt Efternamn krävs.',
                's_email.required' => 'Frakt e-postadress krävs.',
                's_phone.required' => 'Fraktelefon krävs.',
                's_address.required' => 'Fraktadress krävs.',
                's_apartment.required' => 'Frakt Lägenhetsinformation krävs.',
                's_city.required' => 'Fraktstad krävs.',
                'datetime.required' => 'Välj leveransdatum.',
                's_post_code.required' => 'Frakt postnummer krävs.'

            );

            $rules1=[
                'first_name'=>['required', 'required:users,first_name','max:30'],
                'last_name'=>['required', 'required:users,last_name','max:30'],
                'email'=>['required', 'unique:users,email', 'max:64'],
                'password'=>['required', 'required:users,password','min:6','max:25'],
                'confirm_password'=>['required','same:password'],
            ];

            $messages1 = array(
                'first_name.required' => 'Förnamn krävs.',
                'first_name.max' => 'Förnamnets charterfält inte mer än 30.',
                'last_name.required' => 'Efternamn krävs.',
                'last_name.max' => 'Efternamn charterfält inte mer än 30.',
                'email.required' => 'E-postfält krävs.',
                'password.required' => 'Lösenordsfält krävs.',
                'password.min' => 'Lösenordet måste vara 6 tecken långt.',
                'password.max' => 'Lösenordstecken högst 25.',
                'confirm_password.required' => 'Bekräfta lösenordsfältet krävs.',
                'confirm_password.same' => 'Fältet Lösenord och bekräfta lösenord måste vara samma',
                'email.unique' => $request->input('email').'E-post finns redan!',
            );
        }else{
            $rules=[
                'first_name'=>['required', 'required:users,first_name','max:30'],
                'last_name'=>['required', 'required:users,last_name','max:30'],
                'email'=>['required', 'required:users,email', 'max:64'],
                //this validation is for shipping address
                's_first_name'=>['required', 'required:user_details,first_name','max:30'],
                's_last_name'=>['required', 'required:user_details,last_name','max:30'],
                's_email'=>['required', 'required:user_details,email','max:30'],
                's_phone'=>['required', 'required:user_details,phone','max:30'],
                's_address'=>['required', 'required:user_details,address','max:30'],
                's_apartment'=>['required', 'required:user_details,apartment'],
                's_city'=>['required', 'required:user_details,city'],
                'datetime'=>['required', 'required:billings,datetime','max:30'],
                's_post_code'=>['required', 'required:user_details,post_code','max:30'],

            ];
            $messages = array(
                'first_name.required' => 'Förnamn krävs.',
                'first_name.max' => 'Förnamnets charterfält inte mer än 30.',
                'last_name.required' => 'Efternamn krävs.',
                'email.required' => 'E-post krävs.',
                'last_name.max' => 'Efternamnet charecter fält inte mer än 30.',
                //this validation is for shipping address
                's_first_name.required' => 'Frakt Förnamn krävs.',
                's_last_name.required' => 'Frakt Efternamn krävs.',
                's_email.required' => 'Frakt e-postadress krävs.',
                's_phone.required' => 'Fraktelefon krävs.',
                's_address.required' => 'Fraktadress krävs.',
                's_apartment.required' => 'Frakt Lägenhetsinformation krävs.',
                's_city.required' => 'Fraktstad krävs.',
                'datetime.required' => 'Välj leveransdatum.',
                's_post_code.required' => 'Frakt postnummer krävs.'

            );
        }
        if(!Auth::check()){
            $valid1 = Validator::make($request->input(), $rules1, $messages1);
            if($valid1->fails()){
                return redirect()->back()
                    ->withErrors($valid1)
                    ->withInput();
            }
        }
        $valid = Validator::make($request->input(), $rules, $messages);
        if($valid->fails()){
            return redirect()->back()
                ->withErrors($valid)
                ->withInput();
        }else{
            $getSessionProducts = Session::get('cart');
            if(empty($getSessionProducts)){
                Session::flash('error', 'Produktdata hittades inte!');
                return redirect('search-catarine');
            }
            //first create to user account
            if(Auth::check()){
                $users = User::where('id',Auth::user()->id)->first();
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
                    }
                } catch(\Exception $e){
                    Session::flash('error', 'Oj, något är fel! Kan inte logga in!');
//            return $e->getMessage();
                    return Redirect::back();
                }
                //this code is create for new shipping address
                $userDetail = new UserDetail();
                $userDetail->first_name = $request->input('s_first_name');
                $userDetail->last_name = $request->input('s_last_name');
                $userDetail->email = $request->input('s_email');
                $userDetail->phone = $request->input('s_phone');
                $userDetail->address = $request->input('s_address');
                $userDetail->phone = $request->input('s_phone');
                $userDetail->apartment = $request->input('s_apartment');
                $userDetail->city = $request->input('s_city');
                $userDetail->post_code = $request->input('s_post_code');
                $userDetail->user_id = $users->id;
                $userDetail->save();
            }
        }
        //create new order
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $order = new Order();
        $order->order_by = $users->id;
        $order->order_number = 'invoice-'.date('Y').'-SE-'.rand(100000,999999);
        $order->url = $order->order_number.rand(1000000,99999999);
        $order->order_status = 'created';
        $order->order_date = time();
        $order->total_cost = $request->input('total_cost');
        $order->delivery_charge = $request->input('total_delivery_charge');
        $order->sub_total = $order->total_cost + $order->delivery_charge;
        $order->order_time = time();
        $order->payment_type = $request->input('payment_type');
        if($order->payment_type=="1"){
            $order->payment_details = "Payson";
        }else{
            Session::flash('error', 'Betalningstypmetod hittades inte!');
            return Redirect::back();
        }
        $order->save();
        if(!empty($order->id)){
            $billing = new Billing();
            $billing->first_name = $request->input('s_first_name');
            $billing->last_name = $request->input('s_last_name');
            $billing->email = $request->input('s_email');
            $billing->datetime = $request->input('datetime');
            $billing->phone = $request->input('s_phone');
            $billing->address = $request->input('s_address');
            $billing->phone = $request->input('s_phone');
            $billing->apartment = $request->input('s_apartment');
            $billing->city = $request->input('s_city');
            $billing->post_code = $request->input('s_post_code');
            $billing->user_id = $users->id;
            $billing->order_id = $order->id;
            $billing->save();
        }
        //order products is create

        foreach($getSessionProducts as $key => $pid){
            $getProduct = Product::where('id',$pid['product_id'])->first();
            $order_product = new OrderProduct();
            $order_product->product_id = $getProduct->id;
            $order_product->product_title = $getProduct->title;
            $order_product->product_image = $getProduct->main_image;
            $order_product->description = $getProduct->description;
            $order_product->order_id = $order->id;
            $order_product->vendor_id = $getProduct->catarine_id;
            $order_product->quantity = $pid['quantity'];
            $order_product->price = $pid['price'];
            $order_product->total_price = $pid['price'] * $pid['quantity'];
            $order_product->per_delivery_cost = $getProduct->delivery_cost;
            $order_product->total_delivery_cost = $pid['quantity'] * $order_product->per_delivery_cost;
            $order_product->total_product_cost = ($order_product->price * $pid['quantity']) + $order_product->total_delivery_cost;
            $order_product->vendor_price = $getProduct->catarine_price;
            $order_product->maintain_cost = 5 * $pid['quantity'];
            $order_product->vendor_total_price = $order_product->vendor_price * $pid['quantity'];
            $order_product->total_expense_cost = $order_product->vendor_total_price + $order_product->total_delivery_cost;
            $order_product->benefit_of_product = $order_product->total_product_cost - ($order_product->vendor_total_price + $order_product->total_delivery_cost) - $order_product->maintain_cost;
            $order_product->save();
        }
        //create product array list
        $dataProduct = array();
        foreach($getSessionProducts as $prow){
            $get_product = Product::where('id',$prow['product_id'])->first();
            $dataProduct[] = array(
                'name' => $get_product->title,
                'unitPrice' => $get_product->after_discount_price + $get_product->delivery_cost,
                'quantity' => $prow['quantity'],
                'imageUri' => url('public/products/main_image/'.$get_product->main_image),
                'taxRate' => '0.00',
            );
        }
        //create payment
        $agentId = '3770';
        $apiKey = '77c2484c-5408-4749-94fe-edd214f02ca8';
        $apiUrl = \Payson\Payments\Transport\Connector::TEST_BASE_URL;
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);
        $checkoutClient = new \Payson\Payments\CheckoutClient($connector);

        $data = array(
            'customer' => array(
                'city' => $request->input('s_city'),
                'email' => $request->input('s_email'),
                'firstName' => $request->input('s_first_name'),
                'lastName' => $request->input('s_last_name'),
                'phone' => $request->input('s_phone'),
                'postalCode' => $request->input('s_post_code'),
                'street' => $request->input('s_address'),
            ),
            'merchant' => array(
                'checkoutUri' => url('checkout'),
                'confirmationUri' => url('confirmation'),
                'notificationUri' => url('notification'),
                'termsUri' => url('terms-condition'),
            ),
            'order' => array(
                'currency' => 'sek',
                'items' => $dataProduct
            )
        );
        $checkout['cart'] = Session::get('cart');
        $getResponse = $checkoutClient->create($data);
        if(empty($getResponse)){
            Session::flash('error','Payson Connection error. Internal server error!');
            return redirect('search-catarine');
        }
        $checkout['after_order'] = $getResponse;
        //dd($checkout['after_order']);
        //exit();
        Session::put('transaction_id',$getResponse['id']);
        Session::put('order_number',$order->order_number);
        return view('product/checkout',$checkout);
    }
    //this code is for order create and also billings
    public function order_create(){

    }
    //checkout page
    public function checkout(){
        $data['cart'] = Session::get('cart');
        $data['page_title'] = 'Checkout Page';
        return view('product/checkout',$data);
    }
    //checkout confirmation page
    public function confirmation(){
        $agentId = '3770';
        $apiKey = '77c2484c-5408-4749-94fe-edd214f02ca8';
        $apiUrl = \Payson\Payments\Transport\Connector::TEST_BASE_URL;
        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);
        $checkoutClient = new \Payson\Payments\CheckoutClient($connector);
        $data = array(
            'id' => Session::get('transaction_id'),
        );
        $getInfo = $checkoutClient->get($data);
        if(empty($getInfo)){
            Session::flash('error','Payson Connection error. Internal server error!');
            return redirect('search-catarine');
        }
        //dd(Session::get('transaction_id'));
        //exit();
        $info['info'] = $getInfo;
        $order_number = Session::get('order_number');
        $transaction_id = Session::get('transaction_id');
        $updateData = array(
            'transation_id' => $transaction_id,
            'purchaseId' => $getInfo['purchaseId'],
            'order_status' => $getInfo['status'],
        );
        $update = Order::where('order_number',$order_number)->update($updateData);
        //Session::forget('order_number');
        //Session::forget('transaction_id');
        //dd($info['info']);
        //exit();
        Session::forget('cart');
        $data['page_title'] = 'Kassasida';
        return view('product/confirmation',$info);
    }
    //checkout notification page
    public function notification(){
        $data['page_title'] = 'Underrättelse';
        return view('product/notification',$data);
    }
    //test account check
    public function connector(){
        $agentId = '3770';
        $apiKey = '77c2484c-5408-4749-94fe-edd214f02ca8';
        $apiUrl = \Payson\Payments\Transport\Connector::TEST_BASE_URL;

        $connector = \Payson\Payments\Transport\Connector::init($agentId, $apiKey, $apiUrl);
        $checkoutClient = new \Payson\Payments\CheckoutClient($connector);

        $accountInformation = $checkoutClient->getAccountInfo();
        return $accountInformation;
    }
    //this cod is for admin panel to all incoming order
    public function all_incoming_orders(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "admin") {
            return redirect('/');
        }
        $data['order_list'] = true;
        $data['new_order'] = true;
        $data['orders'] = Order::where('status',0)->orderBy('id','desc')->paginate(10);
        $data['page_title'] = 'All Incoming Orders';
        return view('product/all_orders',$data);
    }
    //confirmation orders
    public function admin_order_details($url=NULL){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "admin") {
            return redirect('/');
        }
        if(empty($url)){
            Session::flash('error','Order Url not found');
            return redirect('all-incoming-orders');
        }
        $data['order'] = Order::where('url',$url)->first();
        $data['order_products'] = OrderProduct::where('order_id',$data['order']->id)->get();
        $data['page_title'] = 'Order product details';
        return view('product/order_product_details',$data);
    }
    //direct order confirmation
    public function order_direct_confirmation($url=NULL){
        if(empty($url)){
            Session::flash('error','Order url not found!');
            return redirect('all-incoming-orders');
        }
        $order = Order::where('url',$url)->where('purchaseId','<>',null)->where('order_status','readyToShip')->first();
        if(empty($order)){
            Session::flash('error','Order Data not found! Server Error Payment not complete!');
            return redirect('all-incoming-orders');
        }
        $order_details = OrderProduct::where('order_id',$order->id)->get();
        if(empty($order_details)){
            Session::flash('error','Internal Server error, Order product not found!');
            return redirect('all-incoming-orders');
        }
        //get the order product payment calculation
        $vendor_total_price =0;
        $total_maintain_cost =0;
        $total_expense = 0;
        $total_benefit = 0;
        foreach($order_details as $row){
            $vendor_total_price += $row->vendor_total_price;
            $total_maintain_cost += $row->maintain_cost;
            $total_expense += $row->total_expense_cost;
            $total_benefit += $row->benefit_of_product;
        }
        //order data update
        $order->sub_total_vendor = $vendor_total_price;
        $order->total_maintain_cost = $total_maintain_cost;
        $order->total_expense = $total_expense;
        $order->total_benefit = $total_benefit;
        $order->discount = 0;
        $order->last_balance = $total_benefit - $order->total_maintain_cost;
        $order->status = 4;
        $order->save();
        Session::flash('success','Order Confirmed!');
        return redirect('all-confirmed-orders');
    }
    //this code is for all confirmed order
    public function all_confirmed_orders(){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "admin") {
            return redirect('/');
        }
        $data['confirmed_orders'] = Order::where('status',4)->orderBy('id','desc')->paginate(10);
        $data['order_list'] = true;
        $data['all_confirmed_order'] = true;
        $data['page_title'] = 'Order product details';
        return view('product/all_confirmed_orders',$data);
    }
    //this code is for get order details by admin
    public function get_order_details_by_admin($url=NULL){
        if(!Auth::check() && Auth::user()->role != "admin"){
            return redirect('user-login');
        }
        if(empty($url)){
            Session::flash('error','Fakturanummer hittades inte. internt serverfel!');
            return redirect('all-confirmed-orders');
        }
        $data['order'] = Order::where('url',$url)->first();
        if(empty($data['order'])){
            Session::flash('error','Du har inte någon tillåtelse att se denna faktura!');
            return redirect('all-confirmed-orders');
        }
        $data['order_products'] = OrderProduct::where('order_id',$data['order']->id)->get();
        $data['billing'] = Billing::where('order_id',$data['order']->id)->where('user_id',$data['order']->order_by)->first();
        $data['catarine'] = User::where('id',$data['order_products'][0]->vendor_id)->first();
        $data['profile_current'] = true;
        return view('product/get_order_details_by_admin',$data);
    }
    //this code is for get current order by ajax request
    public function get_current_order(Request $request){
        if(!Auth::check() && Auth::user()->role != "admin"){
            $data['result'] = array(
                'key' =>102,
                'val' => 'you are not admin. Login as administrator then get current order!'
            );
            return response()->json($data,200);
        }
        $get_order = Order::where('status',0)->get();
        $data['result'] = array(
            'key' =>200,
            'val' => count($get_order)
        );
        return response()->json($data,200);
    }
    //this code is for changed main image by catarine
    public function change_image_by_catarine($url=NULL){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(empty($url) && Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $data['product'] = Product::where('url',$url)->where('catarine_id',Auth::user()->id)->first();
        if(empty($data['product'])){
            Session::flash('error','Catarine food not found!');
            return redirect('all-catarine-food');
        }
        $data['product_catarine'] = True;
        $data['all_catarine_food'] = True;
        return view('catarine/change_main_image_by_catarine',$data);
    }
    //post main food item image
    public function change_image_by_catarine_post(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $url = $request->input('product_url');
        $product = Product::where('url',$url)->where('catarine_id',Auth::user()->id)->first();
        if(empty($product)){
            Session::flash('error', 'You don,t have any permission to change main food image!');
            return redirect('all-catarine-food');
        }
        $image = $request->file('main_food_image');
        if($request->hasFile('main_food_image')){
            if(!empty($product->main_image)){
                $updateFileName = base_path().'/public/products/main_image/'.$product->main_image;
                if(File::exists($updateFileName)){
                    File::delete($updateFileName);
                }
            }
            $ext = $image->getClientOriginalExtension();
            $filename = $image->getClientOriginalName();
            $filename = rand(1000,100000).'.'.$ext;
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(234,234);
            $image_resize->save(public_path('products/main_image/' .$filename));
            $product->main_image = $filename;
            $product->save();
            Session::flash('success', 'Main Food Image Updated Successfully.');
            return redirect('all-catarine-food');
        }else{
            Session::flash('error', 'You did,t select any image:)');
            return redirect('change-image-by-catarine/'.$product->url);
        }
    }
    //show all detail images
    public function all_detail_images_by_catarine($url=NULL){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(empty($url) && Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $data['product'] = Product::where('url',$url)->where('catarine_id',Auth::user()->id)->first();
        if(empty($data['product'])){
            Session::flash('error','Catarine food not found!');
            return redirect('all-catarine-food');
        }
        $data['product_images'] = MoreImage::where('product_id',$data['product']->id)->paginate(10);
        //dd($data['product_images']);
        //exit();
        $data['product_catarine'] = True;
        $data['all_catarine_food_images'] = True;
        return view('catarine/all_detail_images_by_catarine',$data);
    }
    //delete detail image
    public function delete_detail_image($id=NULL){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(empty($id) && Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $getData = MoreImage::where('id',$id)->first();
        if(empty($getData)){
            Session::flash('error','Image data not found!');
            return redirect()->back();
        }
        $product = Product::where('id',$getData->product_id)->where('catarine_id',Auth::user()->id)->first();
        if(empty($product)){
            Session::flash('error','You don,t have any permission to delete this image!');
            return redirect()->back();
        }
        //image delete
        if(!empty($getData->image)){
            $updateFileName = base_path().'/public/products/more_images/'.$getData->image;
            if(File::exists($updateFileName)){
                File::delete($updateFileName);
            }
        }
        //delete row
        $getData->delete();
        Session::flash('success','Image Deleted Successfully!');
        return redirect('all-detail-images-by-catarine/'.$product->url);
    }
    //post multiple images by catarine
    public function create_product_images_by_catarine_post(Request $request){
        if(!Auth::check()){
            return redirect('user-login');
        }
        if(Auth::user()->role != "catarine") {
            return redirect('/');
        }
        $url = $request->input('product_url');
        $check = Product::where('url',$url)->where('catarine_id',Auth::user()->id)->first();
        if(empty($check)){
            Session::flash('error','You don,t have any permission to delete this image!');
            return redirect()->back();
        }
        //more image upload code
        $images = $request->file('more_images');
        if($request->hasFile('more_images')){
            foreach($images as $row){
                $more_image = new MoreImage();
                $ext = $row->getClientOriginalExtension();
                $filename = $row->getClientOriginalName();
                $filename = rand(1000,100000).'.'.$ext;
                $image_resize = Image::make($row->getRealPath());
                $image_resize->resize(600,600);
                $image_resize->save(public_path('products/more_images/' .$filename));
                $more_image->image = $filename;
                $more_image->product_id = $check->id;
                $more_image->save();
            }
        }else{
            Session::flash('error', 'You select at least one image:)');
            return redirect('all-detail-images-by-catarine/'.$check->url);
        }
        Session::flash('success','Images Uploaded Successfully!');
        return redirect('all-detail-images-by-catarine/'.$check->url);
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
