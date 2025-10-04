<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MICROSERVICE_USERS');
        $this->apiKey = env('API_KEY');
}
    public function index()
    {

        $url = $this->apiUrl . '/users/';
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $url = $this->apiUrl . '/users/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        return $response->json();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $url = $this->apiUrl . '/users/' . $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])
            ->put($url, $request->all());

        return $response->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $url = $this->apiUrl . '/users/'. $id;
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->delete($url);
        return $response->json();
    }
}
