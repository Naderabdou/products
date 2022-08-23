<?php
namespace App\Repository;



use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rate;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Routing\Loader\Configurator\collection;

class ApiProductsRepository implements ApiProductsRepositoryInterface{
    public function trait($data=null , $message=null , $status=null){
        $array=[
            'data'=>$data,
            'message'=>$message,
            'status'=>$status
        ];
        return response($array);
    }
    //// curd Product Api ////
    public function getAllProducts()

    {


        $products= ProductResource::collection(Product::get());
        return $this->trait($products , 'ok' , 200);




    }
    public function store(Request $request){
        $data = validator::make($request->all(),[
            'name'=>'required|string',
            'desc'=>'string',
            'img'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'price'=>'required|numeric'
        ]);

        if ($data->fails()){
            return $this->trait(null , $data->errors() , 400);

        }


      $product=  Product::create($request->all());
        if ($product){
            return $this->trait(new ProductResource($product)  , 'the product is save' , 201);
        }


    }
    public function destroy ($id){
       $product= Product::find($id);
        if (!$product) {
            return $this->trait('null'  , 'this product not found' , 404);
        }
        $product->delete();

        if ($product){
            return $this->trait(null  , 'the product is Deleted' , 200);
        }



    }
    public function update(Request $request , $id){
        $data = validator::make($request->all(),[
            'name'=>'string',
            'desc'=>'string',
            'img'=>'image|mimes:jpeg,png,jpg,gif,svg',
            'price'=>'numeric'
        ]);

        if ($data->fails()){
            return $this->trait(null , $data->errors() , 400);

        }

        $ProductUpdate= Product::find($id);

        if (!$ProductUpdate) {
            return $this->trait('null'  , 'this product not found' , 404);
        }
        $ProductUpdate->update($request->all());
        if ($ProductUpdate){
            return $this->trait(new ProductResource($ProductUpdate)  , 'the product is update' , 201);
        }

    }
    public  function show($id){
       $product= Product::find($id);
       if ($product){
           return $this->trait(new ProductResource($product)  , 'ok' , 200);

       }else{
           return $this->trait(null , 'Not Found' , 404);

       }



    }
    ///// end ////





     /// Get all the products to show to users //
    public function shop(){
        $products= ProductResource::collection(Product::get());
        return $this->trait($products , 'ok' , 200);
}
    /// end //

    //// store product in your cart ///
    public function cart(Request $request){
        $data = validator::make($request->all(),[
            'product_id'=>'required',

        ]);

        if ($data->fails()){
            return $this->trait(null , $data->errors() , 400);

        }
        $currentUser = Auth::user()->id;


     $product=   Product::all();
       $product_id= $product->map(function ($e){
          return  $e->id;
        })->toArray();

       if (in_array($request->product_id , $product_id)){
           $user=User::findorfail($currentUser);
           $user->cart()->syncWithoutDetaching($request->product_id);

           $product=Product::findorFail($request->product_id);

           if ($user){
               return $this->trait(new ProductResource($product)  , 'the product is save in cart' , 200);
           }

       }else{
           return $this->trait(null  , 'the product is Not Found' , 404);

       }


    }
    /// end ////

    //// delete product form your cart //
    public function delete_cart($product_id){
       
        $product= Product::find($product_id);
        $currentUser = Auth::user()->id;
        $user=User::find($currentUser);

        if (!$product && !$user) {
            return $this->trait('null'  , 'this product not found' , 404);
        }

        $user->cart()->detach($product_id);

        if ($product){
            return $this->trait(null  , 'the product is Deleted' , 200);
        }
    }
    /// end ////

    /// show all the products in your cart //
    public function all_cart(){
        $currentUser = Auth::user()->id;

        $user=  User::find( $currentUser);
        if (!$user){
            return $this->trait(null , 'this user is not Found' , 404);

        }
        $cart=$user->cart;
        if (count($cart) > 0 ){
            return $this->trait($cart , 'ok' , 200);

        }else{
            return $this->trait(null , 'please add product in your cart' , 200);

        }



    }
    /// end ///

    //// payment product ///
    public function payment($product_id){
        $currentUser = Auth::user()->id;

       $product= Product::findorFail($product_id);
      $user= User::findorFail($currentUser);

        $data['amount']= $product->price;
        $data['currency']= "USD";
        $data['customer']['first_name']=$user->name;
        $data['customer']['email']=$user->email;
        $data['source']['id']="src_card";
        $data['redirect']['url']=route('api.callback',['product_id'=>$product_id , 'user_id'=>$user_id]);
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
    //// end ///


    //// if payment is success redirect on this function //
    public function callback(Request $request,$product_id){
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
        $output=curl_exec($ch);
        curl_close($ch);
        $currentUser = Auth::user()->id;

        $user=User::findorfail($currentUser);
        $user->order()->syncWithoutDetaching($product_id);
        return $this->trait($output , 'Successful payment' , 200);



    }
    /// end ////

}
