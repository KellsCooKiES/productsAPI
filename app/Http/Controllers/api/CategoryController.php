<?php

namespace App\Http\Controllers\api;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories =Category::all();

        if (is_null($categories)) {
            return $this->sendError('Products not found.');
        }
        return $this->sendResponse($categories->toArray(),'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'external_id'=> 'unique:categories|required|integer',
            'parent_id' => 'integer'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }

        $category = new Category([
            'name' => $request->input('name'),
            'external_id'=> $request->input('external_id'),
            'parent_id' => $request->input('parent_id')
        ]);

        //attach product with categories

        $category->save();

        return $this->sendResponse($category->id,'successfully created');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'external_id'=> 'unique:categories|required|integer',
            'parent_id' => 'integer'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->messages());
        }

        $category->update([
            'name' => $request->input('name'),
            'external_id'=> $request->input('external_id'),
            'parent_id' => $request->input('parent_id')
        ]);
        return $this->sendResponse($category->id,'successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $id = $category->id;
        $category->delete();

        return $this->sendResponse('Category id: '.$id,'successfully deleted');
    }

    /**
     * @param $categories
     * @return bool
     */
    public static function addCategoriesConsole($categories)
    {
         foreach ( $categories as $categoryData){

             $oldCategory = Category::where('external_id', '=', $categoryData['external_id'])->first();
             //check if exists
             if ($oldCategory === null) {

                //   if not exists save
                 $validator = Validator::make($categoryData, [
                     'name' => 'required|max:200',
                     'external_id' => 'unique:categories|required|integer',
                 ]);

                 if ($validator->fails()) {
                      return $validator->errors()->first();

                 }

                 $category = new Category([
                     'name' => $categoryData['name'],
                     'external_id' => $categoryData['external_id'],
                 ]);

                 $category->save();
             } else {

                 //else update
                 $validator = Validator::make($categoryData, [
                     'name' => 'required|max:200',
                     'external_id' => 'integer|required',
                 ]);
                 if ($validator->fails()) {
                     return $validator->errors()->first();
                 }

                 $oldCategory->update([
                     'name' => $categoryData['name'],
                     'external_id' => $categoryData['external_id'],
                 ]);
             }
         }
        return true;
    }
}
