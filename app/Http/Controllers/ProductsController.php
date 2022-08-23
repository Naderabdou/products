<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;
use App\Repository\ProductsRepositoryInterface;

class ProductsController extends Controller
{
    //
    protected $Product;

    public function __construct(ProductsRepositoryInterface $Product)
    {
        $this->Product = $Product;
    }
    //// curd Product  ////
    public function index(){
        return $this->Product->getAllProducts();
    }
    public function store(ProductStoreRequest $request){
         return $this->Product->store($request);
    }
    public  function destroy($id){
        return $this->Product->destroy($id);
    }
    public function update(ProductUpdateRequest $request , $id){
        return $this->Product->update($request,$id);
    }
    public function show($id){
        return $this->Product->show($id);
    }
    /// end //


    public function shop(){
        return $this->Product->shop();

    }

    public function rate(Request $request){
        return $this->Product->rate($request);

    }


    public function cart(Request $request){
        return $this->Product->cart($request);
    }
    public function delete_cart($user_id,$product_id){
        return $this->Product->delete_cart($user_id,$product_id);
    }
    public function all_cart($id){
        return $this->Product->all_cart($id);
    }


    public function payment($product_id,$user_id){
        return $this->Product->payment($product_id,$user_id);
    }
    public function callback(Request $request,$product_id,$user_id){
        return $this->Product->callback($request,$product_id,$user_id);
    }


}
