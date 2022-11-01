<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 20;

        $qb = Category::query()->with('products');
        $data = $qb->offset($offset)->limit($limit)->get();

        return response($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->published =$request->published;

        $category->save();

        if (!empty($category)) {
            return response([
                'data'=>$category,
                'message' => 'New category succesfull inserted!'
            ], 200);
        } else {
            return response(['message' => 'Category can not inserted!!!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category = Category::find($category->id);
        $category->name = $request->name;
        $category->published = $request->published;
        $category->save();

        return response([
            'data'=>$category,
            'message'=>'Category updated!'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
       /* return response([
            'message'=>'Category deleted!'
        ],200);*/
        return $this->apiResponse($category,'Category deleted!',200);
    }

    public function custom1()
    {
        return Category::pluck('name', 'id');
    }

    public function report1()
    {
        return DB::table('product_categories as pc')
            ->selectRaw('c.name as categoryName,count(*) as total')
            ->join('categories as c', 'c.id', '=', 'pc.category_id')
            ->join('products as p', 'p.id', '=', 'pc.product_id')
            ->groupBy('c.name')
            ->orderByRaw('count(*) asc')
            ->get();
    }

}
