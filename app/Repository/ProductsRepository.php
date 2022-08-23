<?php
namespace App\Repository;



use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsRepository implements ProductsRepositoryInterface{
    //// curd Product  ////
    public function getAllProducts()
    {

      $products=  Product::get();

      return view('dashboard.product.index',compact('products'));
    }
    public function store(ProductStoreRequest $request){
       $data= $request->validated();
        if ($data['img'] != ''){
            $path=Storage::disk('public')->putFile('/splash',$request->img);
            $data['img']=$path;
    }
        Product::create($data);
        return redirect()->back()->with('message', 'تم الاضافة بنجاح');
    }
    public function destroy ($id){
        Product::destroy($id);
        return redirect()->back()->with('message', ' تم الحذف بنجاح');
    }
    public function update(ProductUpdateRequest $request , $id){
        $ProductUpdate= Product::findorfail($id);
        $data=$request->validated();
        if ($request->has('img')){
            $path=Storage::disk('public')->putFile('/GalleryCategory',$request->img);
            $data['img']=$path;
        }

        $ProductUpdate->update($data);
        return redirect()->back()->with('message', ' تم التعديل بنجاح');

    }
    public  function show($id){
       $product= Product::findorFail($id);
       $rate= Rate::where('user_id','=',auth()->user()->id)->where('product_id','=',$id)->get();
        return view('dashboard.product.show',compact('product','rate'));

    }
   //// end ////

    /// Get all the products to show to users //
    public function shop(){
       $products= Product::paginate(5);
       return view('dashboard.product.shop',compact('products'));
}
    /// end

    //// rate on product ///
    public function rate(Request $request)
    {
        $data = $request->validate([
            'rate' => '',
            'user_id' => '',
            'product_id' => ''
        ]);

        if ($request->ajax()){
            Rate::create([
                'rate'=>$data['rate'],
                'user_id'=>$data['user_id'],
                'product_id'=>$data['product_id']

            ]);
            $rate= Rate::where('user_id','=',$request->user_id)->get();
            $output = '';
            if (count($rate) > 0){
                for ($i=0; $i<$request->rate; $i++){






                    $output .= '<i class="fas fa-star d-inline-block" style="color:yellow;"></i>';



                }

                return Response($output);

            }}


    }
    /// end  ///




    //// store product in your cart ///
    public function cart(Request $request){
        $user=User::findorfail($request->user_id);
        $user->cart()->syncWithoutDetaching($request->product_id);

        return redirect()->back()->with('message','تم الاضافه بنجاح');
    }
    /// end //

       //// delete product form your cart //
    public function delete_cart($user_id,$product_id){
        $user=User::findorfail($user_id);
        $user->cart()->detach($product_id);
        return redirect()->route('admin.shop')->with('message','تم لحذف بنجاح');
    }
    /// end //

    /// show all the products in your cart //
    public function all_cart($id){
      $user=  User::findorFail($id);
      $cart=$user->cart;
      return view('dashboard.product.cart',compact('cart'));



    }
    /// end //



    //// payment product ///
    public function payment($product_id,$user_id){
       $product= Product::findorFail($product_id);
      $user= User::findorFail($user_id);

        $data['amount']= $product->price;
        $data['currency']= "USD";
        $data['customer']['first_name']=$user->name;
        $data['customer']['email']=$user->email;
        $data['source']['id']="src_card";
        $data['redirect']['url']=route('admin.callback',['product_id'=>$product_id , 'user_id'=>$user_id]);
        $header=[
            'Content-Type: application/json',
            'Authorization: Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ'
        ];
        $ch= curl_init();
        $url= 'https://api.tap.company/v2/authorize';
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $output= curl_exec($ch);
        curl_close($ch);
        $response = json_decode($output)
        ;
       return redirect()->to($response->transaction->url);





    }
   /// end ///




    //// if payment is success redirect on this function //
    public function callback(Request $request,$product_id,$user_id){
$input = $request->all();
        $header=[
            'Content-Type: application/json',
            'Authorization: Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ'
        ];
        $ch= curl_init();
        $url= 'https://api.tap.company/v2/authorize/'.$input['tap_id'];
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_exec($ch);
        curl_close($ch);
        $user=User::findorfail($user_id);
        $user->order()->syncWithoutDetaching($product_id);
        return redirect()->route('admin.shop')->with('message','لقد تم الدفع بنجاح');



    }
    /// end //

}
