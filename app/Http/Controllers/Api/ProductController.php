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

    public function update(Request $request, Product $product)
    {
        Log::info('Attempting to update product', [
            'product_id' => $product->id,
            'content_type' => $request->header('Content-Type'),
            'method' => $request->method(),
            'raw_content' => $request->getContent()
        ]);

        // Parse the input data based on content type
        if ($request->isJson() || $request->header('Content-Type') === 'text/plain') {
            // Handle JSON data, even if Content-Type is incorrectly set to text/plain
            $data = json_decode($request->getContent(), true) ?? [];
        } elseif (strpos($request->header('Content-Type'), 'multipart/form-data') !== false) {
            // For multipart form data, we need to parse it manually
            $data = [];
            foreach ($request->all() as $key => $value) {
                if ($request->hasFile($key)) {
                    $data[$key] = $request->file($key);
                } else {
                    $data[$key] = $value;
                }
            }
        } else {
            // For other content types, try to parse as form data
            parse_str($request->getContent(), $data);
        }

        Log::info('Parsed request data', ['data' => $data]);

        $validator = Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return response()->json($validator->errors(), 400);
        }

        $product->update($data);

        Log::info('Product updated successfully', ['product_id' => $product->id]);

        return response()->json($product, 200);
    }

    public function destroy(Product $product)
    {
        Log::info('Attempting to delete product', ['product_id' => $product->id]);

        $product->delete();

        Log::info('Product deleted successfully', ['product_id' => $product->id]);

        return response()->json(null, 204);
    }
}
