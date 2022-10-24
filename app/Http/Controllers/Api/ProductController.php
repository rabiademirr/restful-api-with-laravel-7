<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsWithCategoriesResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @OA\Get (
     *     path="/api/products" ,
     *    tags={"product"},
     *     summary="List all products",
     * @Oa\Response(
     *     response=200,
     *     description="Paginated products"
     * )
     * )
     */
    public function index(Request $request)
    {
        //return  Product::all();
        //return response([Product::paginate(10)],200);

        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 15;

        // $offset = $request->has('offset') ? $request->query('offset') : 0;
        //$limit = $request->has('limit') ? $request->query('limit') : 0;

        $qBuilder = Product::query()->with('categories');

        if ($request->has('search_query')) {
            $qBuilder->where('name', 'like', '%' . $request->query('search_query') . '%');

        }
        if ($request->has('sortBy')) {
            $qBuilder->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));
        }
        $data = $qBuilder->offset($offset)->limit($limit)->get();

        return response($data, 200);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->sku = $request->sku;

        $product->save();

        if (!empty($product)) {
            return response([
                'data' => $product,
                'message' => 'Product created'
            ], 201);
        } else {
            return response(['message' => 'Product can not inserted!']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response($product, 200);
        } else {
            return response(["Message" => "Product not found!"], 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = Product::find($product->id);

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->sku = $request->sku;
        $product->save();

        return response(['data' => $product,
            'message' => 'Product updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        $product->delete();

        return response(['message' => 'Product deleted'], 200);
    }

    public function custom1()
    {
        /* return Product::select('id','name', 'slug', 'description')
                         ->orderBy('created_at', 'desc')
                         ->take(15)
                         ->get();*/

        return Product::selectRaw('id as  productId,name as productName, slug, description')
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();
    }

    public function custom2()
    {
        $products = Product::orderBy('id', 'asc')->take(15)->get();

        $mapped = $products->map(function ($product) {
            return [
                'productId' => $product['id'],
                'productName' => $product['name'],
                'price' => $product['price'] * 1.20

            ];
        });
        return $mapped;
    }

    public function paginate()
    {
        $products = Product::paginate(10);

        return ProductResource::collection($products);
    }

    public function listWithCategories()
    {
        //$products = Product::paginate(20);
        $products = Product::with('categories')->paginate(20);

        return ProductsWithCategoriesResource::collection($products);
    }
}
