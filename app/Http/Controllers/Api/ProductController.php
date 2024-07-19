<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        Log::info('Fetching all products');
        $products = Product::all();
        Log::info('Fetched ' . count($products) . ' products');
        return $products;
    }

    public function store(Request $request)
    {
        Log::info('Attempting to create a new product', $request->all());

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($request->all());

        Log::info('Product created successfully', ['product_id' => $product->id]);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        Log::info('Fetching product', ['product_id' => $product->id]);
        return $product;
    }

    public function update(Request $request, $id)
    {
        // Fun fact: Laravel handles PUT requests differently from POST requests,
        // especially when it comes to parsing the request body.
        // Only use JSON with PUT requests, not form data.
        Log::info('Attempting to update product', [
            'product_id' => $id,
            'content_type' => $request->header('Content-Type'),
            'method' => $request->method(),
            'raw_content' => $request->getContent()
        ]);

        // Decode the JSON request
        $data = json_decode($request->getContent(), true);

        // Log parsed request data
        Log::info('Parsed request data, updated product successfully', ['data' => $data]);

        // Validate the data
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find and update the product
        $product = Product::find($id);
        if ($product) {
            $product->update($data);
            return response()->json($product, 200);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function destroy(Product $product)
    {
        Log::info('Attempting to delete product', ['product_id' => $product->id]);

        $product->delete();

        Log::info('Product deleted successfully', ['product_id' => $product->id]);

        return response()->json(null, 204);
    }
}
