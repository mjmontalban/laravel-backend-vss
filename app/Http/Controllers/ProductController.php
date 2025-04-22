<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
// use App\Traits\ResponseTrait;
use App\Http\Requests\CreateProductRequest;
use App\Http\Resources\ProductResource;
class ProductController extends Controller
{
    // use ResponseTrait;

    const DELETED = 1;
    public function create(CreateProductRequest $request) {
        try {

            $payload = [];
            $payload["user_id"] = $request->session()->get('userId');
            $payload = [...$payload, ...$request->validated()];
            Product::create($payload);

            return response()->json([
                "status" => true,
                "message" => "Product created"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    public function edit(EditProductRequest $request) {
        try {
            
            $payload = $request->validated();
            
            $product = Product::find($payload["id"]);

            $product->name = $payload["name"];
            $product->quantity = $payload["quantity"];

            $product->save();


            return response()->json([
                "status" => true,
                "message" => "Saved Successfully"
            ]);

        
        } catch (\Exception $e) {

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    public function delete(Request $request) {
        try {
            
            $id = $request->id;
            $product = Product::find($id);
            $product->is_deleted = SELF::DELETED;
            $product->save();

            return response()->json([
                "status" => true,
                "message" => "Deleted"
            ]);

        
        } catch (\Exception $e) {

            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }


    public function getProducts(Request $request) {
        $limit = $request->limit;
        $offset = $request->offset;
        $userId = $request->session()->get('userId');
        $products = Product::query()
        ->where('user_id', $userId)
        ->where('is_deleted', 0)

        ->take($limit)->skip($offset)->get();

        return ProductResource::collection($products);

    }
}
