<?php

namespace App\Http\Controllers\api;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request )
    {

        $products =Product::query();

        // filters
        if($request->has('price_asc'))
        {
          $products = $products->orderBy('price');
        }
        if($request->has('price_desc'))
        {
            $products = $products->orderBy('price','desc');
        }

        if($request->has('created_at'))
        {
        $products = $products->orderBy('created_at');
        }
        if($request->has('created_at_desc'))
        {
            $products = $products->orderBy('created_at','desc');
        }

        // paginate results
        $products = $products->paginate(50);

        if (is_null($products)) {
            return $this->sendError('Products not found.');
        }
        return $this->sendResponse($products->toArray(),'success');
    }

    /**
     * @param $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexByCategory($categoryId)
    {

        $category = Category::where('external_id',$categoryId)->first();

        //check is category exists
        if (!! is_null($category)) {
            return $this->sendError('Category not found.');
        }
        //get products
          $products = $category->products()->paginate(50);

        if (is_null($products)) {
            return $this->sendError('Products or category not found.');
        }

        return $this->sendResponse($products->toArray(),'success');

    }

    public function show($id)
    {
        $product = Product::where('external_id',$id)->get();
        if (is_null($product)) {
            return $this->sendError('Products not found.');
        }

        return $this->sendResponse($product->toArray(),'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'description' => 'required|max:1000',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'external_id'=> 'unique:products|required',
            'category_id' => 'array|required'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }

       $product = new Product([
           'name' => $request->input('name'),
           'description' => $request->input('description'),
           'price' => $request->input('price'),
           'quantity' => $request->input('quantity'),
           'external_id'=> $request->input('external_id'),
       ]);

       //attach product with categories
       $categoriesId = $request->input('category_id');
       if($product->save()){
           $product->categories()->attach($categoriesId);
       }

       $product->save();

       return $this->sendResponse($product->id,'success');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        $id = $product->id;
        if($product->delete()){
            return $this->sendResponse( 'Product id: '.$id,'Product was deleted');
        }
    }
}
