<?php
namespace App\Repository;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;

interface ProductsRepositoryInterface{
     public function getAllProducts();
     public function store(ProductStoreRequest $request);
     public function destroy($id);
     public function update(ProductUpdateRequest $request, $id);
     public function show ($id);
     public function shop();
     public function rate(Request $request);
     public function cart(Request $request);
     public function all_cart($id);
     public function payment($product_id,$user_id);
     public function callback(Request $request,$product_id,$user_id);
     public function delete_cart($user_id,$product_id);

}
