<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
class ControladorReportes extends Controller
{

    public function GenerarPDF()
    {
        $productos=Product::all();
        //return response()->json($productos);
         // Obtener los productos desde el microservicio
        //$url = $this->apiUrl . '/products';
        //$response = Http::withHeaders(['X-API-Key' => $this->apiKey])->get($url);

        // Generar HTML dinámico
        $html = '
        <h1 style="text-align:center;">Listado de Productos</h1>
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
            <thead>
                <tr style="background:#f2f2f2;">
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Disponibilidad</th>
                </tr>
            </thead>
            <tbody>';

        if (!empty($productos)) {
            foreach ($productos as $p) {
                $html .= '<tr>
                    <td>'.$p['id'].'</td>
                    <td>'.$p['nombre'].'</td>
                    <td>'.$p['precio'].'</td>
                    <td>'.$p['cantidad'].'</td>
                    <td>'.$p['disponibilidad'].'</td>
                </tr>';
            }
        } else {
            $html .= '<tr><td colspan="5" style="text-align:center;">No hay productos</td></tr>';
        }

        $html .= '</tbody></table>
                  <footer style="text-align:center; font-size:12px; margin-top:20px;">
                      Generado '.date('d/m/Y H:i').'
                  </footer>';

        // Cargar el HTML en Dompdf
        $pdf = Pdf::loadHTML($html);

        // Descargar PDF
        return Response::make($pdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename=\"reporte.pdf\"']);
    }
}
