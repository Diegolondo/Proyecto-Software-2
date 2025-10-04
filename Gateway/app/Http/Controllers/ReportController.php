<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ReportController extends Controller
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('MICROSERVICE_REPORTS');
        $this->apiKey = env('API_KEY');
}
    public function reporte()
    {
        $url = $this->apiUrl . '/productos/';
        //return response()->json(['debug' => $url]);
        $response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);
        // Obtener el contenido del PDF
        $pdfContent = $response->body();
    
        // Retornar el PDF al usuario desde el gateway
        return response()->make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="reporte.pdf"',
        ]);
}
}
