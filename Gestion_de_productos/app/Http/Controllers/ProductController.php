<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MICROSERVICE_NOTIFICATIONS');
        $this->apiKey = env('API_KARDEX_KEY');
    }

   public function index()
    {
        $products = Product::all();
        return response()->json($products, 200); 
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        $url = $this->apiUrl . '/send-email';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->post($url, $request->all());
        return response()->json($response->json());
    }
public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product, 200);
    }

public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json($product, 200);
    }

public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}
