<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MICROSERVICE_PRODUCTS'); // En .env defines la URL del microservicio de productos
        $this->apiKey = env('API_KEY');              // API Key para autorización
    }

    /**
     * Listar todos los productos
     */
    public function index()
    {
        $url = $this->apiUrl . '/products';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    /**
     * Crear un producto
     */
    public function store(Request $request)
    {
        $url = $this->apiUrl . '/products';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->post($url, $request->all());

        return $response->json();
    }

    /**
     * Mostrar un producto específico
     */
    public function show($id)
    {
        $url = $this->apiUrl . '/products/' . $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    /**
     * Actualizar un producto
     */
    public function update(Request $request, $id)
    {   
        $url = $this->apiUrl . '/products/' . $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->put($url, $request->all());

        return $response->json();
    }

    /**
     * Eliminar un producto
     */
    public function destroy($id)
    {
        $url = $this->apiUrl . '/products/' . $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->delete($url);
        return $response->json();
    }
}
