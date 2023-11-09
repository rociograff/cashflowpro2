<?php

namespace App\Http\Controllers;

use App\Models\Ahorro;
use App\Models\Gasto;
use App\Models\Ingreso;
use App\Models\Inversion;
use App\Models\Prestamo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    // Mostrar el presupuesto del mes actual
    public function mostrarPresupuestos(Request $request, $user_id, $fechaSeleccionada)
    {
        /**
         * Se extraen las fechas $fechaDesde y $fechaHasta de los parámetros de consulta
         * (query parameters) en la solicitud HTTP.
         *  Estas fechas se utilizan para definir un rango de fechas para filtrar las transacciones financieras.
         */
        $fechaDesde = $request->query('fechaDesde');
        $fechaHasta = $request->query('fechaHasta');

        //Se verifica si $fechaDesde está definido y, si es así, se lo convierte en un objeto Carbon en la zona horaria "America/Argentina/Buenos_Aires".
        if($fechaDesde) {
            $fechaDesde = explode("-", $fechaDesde);
            $fechaDesde = Carbon::create($fechaDesde[0], $fechaDesde[1], $fechaDesde[2])->format('Y-m-d H:i:s', "America/Argentina/Buenos_Aires");
        }

        //Se verifica si $fechaHasta está definido y, si es así, se lo convierte en un objeto Carbon en la zona horaria "America/Argentina/Buenos_Aires".
        if($fechaHasta) {
            $fechaHasta = explode("-", $fechaHasta);
            $fechaHasta = Carbon::create($fechaHasta[0], $fechaHasta[1], $fechaHasta[2])->format('Y-m-d H:i:s', "America/Argentina/Buenos_Aires");
        }
       
        //Se realizan consultas a la base de datos para obtener las transacciones financieras del usuario
        $ahorroUsuario = Ahorro::where('user_id', $user_id)->get();
        $inversionesUsuario = Inversion::where('user_id', $user_id)->get();
        $gastosUsuario = Gasto::where('user_id', $user_id)->get();
        $ingresosUsuario = Ingreso::where('user_id', $user_id)->get();
        $prestamosUsuario = Prestamo::where('user_id', $user_id)->get();

        /**
         * Se realiza una lógica condicional para determinar si se deben aplicar filtros de fecha en las consultas.
         * Si no se proporcionan fechas específicas, se filtran las transacciones por la fecha seleccionada.
         * Si se proporcionan fechas, se filtran las transacciones en el rango de fechas definido.
         */
        if (!$fechaDesde && !$fechaHasta) {
            //  utiliza el ORM (Mapeo Objeto-Relacional) de Laravel para realizar una consulta a la base de datos y obtener registros de la tabla "Inversion" que cumplan con ciertos criterios.
            // se busca y recupera todas las inversiones realizadas por un usuario específico ($user_id) en una fecha específica ($fechaSeleccionada). Los resultados se almacenan en la variable $inversionesUsuario para su posterior procesamiento o visualización.
            $ahorroUsuario = Ahorro::where('user_id', $user_id)->where('created_at', 'like', "%$fechaSeleccionada%")->get(); //2023-10-05 00:00:00
            $inversionesUsuario = Inversion::where('user_id', $user_id)->where('created_at', 'like', "%$fechaSeleccionada%")->get();
            $gastosUsuario = Gasto::where('user_id', $user_id)->where('created_at', 'like', "%$fechaSeleccionada%")->get();
            $ingresosUsuario = Ingreso::where('user_id', $user_id)->where('created_at', 'like', "%$fechaSeleccionada%")->get();
            $prestamosUsuario = Prestamo::where('user_id', $user_id)->where('created_at', 'like', "%$fechaSeleccionada%")->get();
        } else {
            /**
             * estas líneas de código toman una fecha en formato de cadena, la dividen en sus componentes (año, mes y día), y luego la
             * convierten en un objeto Carbon formateado con la zona horaria adecuada para su posterior uso en consultas de base de datos u
             * otras operaciones relacionadas con fechas y horas.
             */
            $fechaSeleccionada = explode("-", $fechaSeleccionada); //  divide esta cadena en un array usando el guion ("-") como separador. El resultado es un array que contiene tres elementos: el año, el mes y el día.
            // Se crea un objeto Carbon a partir de los elementos del array.
            // La función format formatea la fecha y hora en el formato deseado y establece la zona horaria
            $fechaSeleccionada = Carbon::create($fechaSeleccionada[0], $fechaSeleccionada[1], $fechaSeleccionada[2])->format('Y-m-d H:i:s', "America/Argentina/Buenos_Aires");
           
            /**
             * Si $fechaDesde está definido (es decir, no es nulo), entonces $fechaDesde conserva su valor actual.
             * Si $fechaDesde no está definido (es decir, es nulo), se asigna el valor de $fechaSeleccionada a $fechaDesde.
             * Lo mismo con $fechaHasta.
             * Esta lógica se utiliza para garantizar que ambas fechas tengan un valor válido antes de realizar filtrado en las consultas de la base de datos.
             * Si las fechas no se proporcionan en la solicitud o son nulas, se utilizan las fechas seleccionadas (almacenadas en la variable $fechaSeleccionada) como valores predeterminados.
             */
            $fechaDesde = $fechaDesde ?? $fechaSeleccionada;
            $fechaHasta = $fechaHasta ?? $fechaSeleccionada;

            //  busca y recupera todas las inversiones realizadas por un usuario específico ($user_id) dentro de un rango de fechas definido por las variables $fechaDesde y $fechaHasta
            $ahorroUsuario = Ahorro::where('user_id', $user_id)->where('created_at', '>=', $fechaDesde)->where('created_at', '<=', $fechaHasta)->get(); //2023-10-05 00:00:00
            $inversionesUsuario = Inversion::where('user_id', $user_id)->where('created_at', '>=', $fechaDesde)->where('created_at', '<=', $fechaHasta)->get();
            $gastosUsuario = Gasto::where('user_id', $user_id)->where('created_at', '>=', $fechaDesde)->where('created_at', '<=', $fechaHasta)->get();
            $ingresosUsuario = Ingreso::where('user_id', $user_id)->where('created_at', '>=', $fechaDesde)->where('created_at', '<=', $fechaHasta)->get();
            $prestamosUsuario = Prestamo::where('user_id', $user_id)->where('created_at', '>=', $fechaDesde)->where('created_at', '<=', $fechaHasta)->get();
        }

        // Se calcula el total de ingresos, gastos, préstamos, ahorros e inversiones sumando los importes correspondientes.
        // $importe = $ingresosUsuario[0]->importe;
        $totalIngresos = 0;
        foreach ($ingresosUsuario as $ingreso) {
            $totalIngresos += $ingreso->importe;
        }

        $totalGastos = 0;
        foreach ($gastosUsuario as $gasto) {
            $totalGastos += $gasto->importe;
        }

        $totalPrestamos = 0;
        foreach ($prestamosUsuario as $prestamo) {
            $totalPrestamos += $prestamo->importe;
        }

        $totalAhorros = 0;
        foreach ($ahorroUsuario as $ahorro) {
            $totalAhorros += $ahorro->importe;
        }
        // return $totalAhorros;

        $totalInversiones = 0;
        foreach ($inversionesUsuario as $inversion) {
            $totalInversiones += $inversion->importe;
        }

        // Se calcula el "totalHistorial" restando los totales de gastos, préstamos, ahorros e inversiones al total de ingresos.
        $totalHistorial = $totalIngresos - ($totalGastos + $totalPrestamos + $totalAhorros + $totalInversiones);
        // return $historial;

        // Finalmente, se devuelve una respuesta JSON que incluye todos los datos relevantes, como las transacciones, los totales de cada categoría y el totalHistorial.
        return response()->json([
            'ingresos' => $ingresosUsuario,
            'ahorro' => $ahorroUsuario,
            'inversiones' => $inversionesUsuario,
            'gastos' => $gastosUsuario,
            'prestamos' => $prestamosUsuario,
            'totalIngresos' => $totalIngresos,
            'totalGastos' => $totalGastos,
            'totalPrestamos' => $totalPrestamos,
            'totalAhorros' => $totalAhorros,
            'totalInversiones' => $totalInversiones,
            'totalHistorial' => $totalHistorial,
        ]);
    }
}