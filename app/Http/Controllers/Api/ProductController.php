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
     *   @OA\Info(
     *     version="1.0.0",
     *     title="Laravel Api Documentation",
     *     description="This is a sample API documentation.",
     *     @OA\Contact(email="rabiademirr@gmail.com")
     * ),
     *  @OA\Schema(
     *   title="ApiResponse",
     *   description="Api Response Model",
     *   type="object",
     *   schema="ApiResponse",
     *   properties={
     *   @OA\Property(property="success",type="bool"),
     *   @OA\Property(property="message",type="string"),
     *   @OA\Property(property="errors",type="object"),
     *   @OA\Property(property="data",type="object")
     * },),
     *   @OA\Get (
     *     path="/api/products" ,
     *     operationId="index",
     *     tags={"product"},
     *     summary="List all products",
     *    @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     required=true,
     *     description="How many items to return at one time",
     *     @OA\Schema(
     *      type="integer",
     *      format="int32"
     *      ),
     *     ),
     *     @OA\Parameter(
     *     name="offset",
     *     in="query",
     *     required=true,
     *     description="From which number the number of rows to be returned will start"
     *     ),
     *     @OA\Parameter(
     *     name="search_query",
     *     in="query",
     *     required=false,
     *     description="Value to search in product name field"
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Paginated products",
     *     @OA\JsonContent(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Product"),
     *     ),
     *      ),
     *     @OA\Response(
     *     response=401,
     *     description="Unauthorized!",
     *     @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *     response="default",
     *     description="Unexpexted error!",
     *     @OA\JsonContent()
     *      )
     * )
     * @return \Illuminate\Http\Response
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
      *  @OA\Get (
     *     path="/api/products/{productId}" ,
     *     operationId="show",
     *     tags={"product"},
     *     summary="Info for a spesific product",
     *    @OA\Parameter(
     *     name="productId",
     *     in="path",
     *     required=true,
     *     description="Get product by id",
     *     @OA\Schema(
     *      type="integer",
     *      format="int32"
     *      )
     *     ),
     *     @OA\Response(
     *     response=200,
     *     description="Get product by id",
     *     @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *      ),
     *     @OA\Response(
     *     response=401,
     *     description="Unauthorized!",
     *     @OA\JsonContent()
     *      ),
     *     @OA\Response(
     *     response="default",
     *     description="Unexpexted error!",
     *     @OA\JsonContent()
     *      )
     * )
     *
     * Display the specified resource.
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     *
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
