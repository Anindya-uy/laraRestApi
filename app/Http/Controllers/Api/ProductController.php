<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Validator;

class ProductController extends BaseController
{
    public function index(){
        $products = Product::all();
        //return $this->sendResponse($products->toArray(), "Products retrived!");
        return $this->sendResponse(ProductResource::collection($products), "Products retrived!");
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            return sendError('Validation Error', $validator->errors());
        }
        $product = Product::create($request->all());
        return $this->sendResponse(new ProductResource($product), "Product Created Successfully!");
    }
    public function show($id){
        $product = Product::find($id);
        if(is_null($product)){
            return $this->sendError('Product Not Found!');
        }
        else{
            return $this->sendResponse(new ProductResource($product), "Product Shows Successfully!");
        }
    }
}
