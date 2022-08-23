<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\ApiProductsRepositoryInterface;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class ApiProductsController extends Controller
{
    protected $Product;

    public function __construct(ApiProductsRepositoryInterface $Product)
    {
        $this->Product = $Product;
    }
      //// curd Product Api ////
     public function index(){
        return $this->Product->getAllProducts();
    }
     public function show($id){
        return $this->Product->show($id);
    }
     public function store(Request $request){

      return $this->Product->store($request);
     }
     public function update(Request $request,$id){
        return $this->Product->update($request,$id);
     }
     public function destroy($id){
        return $this->Product->destroy($id);
     }
     //// end  ///

     public function shop(){
        return $this->Product->shop();
     }

     public function cart(Request $request){
        return $this->Product->cart($request);
     }
     public  function  delete_cart($product_id){
        return $this->Product->delete_cart($product_id);

     }
     public function all_cart(){
        return $this->Product->all_cart();

     }


    public function payment($product_id){
        return $this->Product->payment($product_id);
    }
    public function callback(Request $request,$product_id){
        return $this->Product->callback($request,$product_id);
    }

}
