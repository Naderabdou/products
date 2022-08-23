<?php
namespace App\Repository;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;

interface ApiProductsRepositoryInterface{
     public function getAllProducts();
     public function store(Request $request);
     public function destroy($id);
     public function update(Request $request, $id);
     public function show ($id);
     public function shop();
     public function cart(Request $request);
     public function all_cart();
     public function payment($product_id);
     public function callback(Request $request,$product_id);
    public function delete_cart($product_id);

}
