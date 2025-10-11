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
    //  Guardar producto en base de datos local (MySQL)
    $product = Product::create([
        'nombre' => $request->input('nombre'),
        'precio' => $request->input('precio'),
        'cantidad' => $request->input('cantidad'),
    ]);

    //  Guardar producto también en Firebase
    try {
        $database = app('firebase.database');
        $database->getReference('products')->push([
            'nombre' => $request->input('nombre'),
            'precio' => $request->input('precio'),
            'cantidad' => $request->input('cantidad'),
            'created_at' => now()->toDateTimeString(),
        ]);
    } catch (\Exception $e) {
        // Si falla Firebase, no interrumpe el proceso ni el envío del correo
        \Log::error('Error al guardar en Firebase: ' . $e->getMessage());
    }

    // Mantener el envío de correo (no se modifica)
    $url = $this->apiUrl . '/send-email';
    $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->post($url, $request->all());

    //  Respuesta final
    return response()->json([
        'message' => 'Producto creado correctamente',
        'producto' => $product,
        'email_response' => $response->json(),
    ], 201);
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
