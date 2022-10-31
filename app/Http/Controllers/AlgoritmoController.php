<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\PuestoVigilancia;
use Illuminate\Http\Request;

class AlgoritmoController extends Controller
{
    public static $personal_clasificado = [];
    public static $nivel_basico = [];
    public static $nivel_medio = [];
    public static $nivel_alto = [];

    public static $h_experto = [];
    public static $h_moderado = [];
    public static $h_intermedio = [];
    public static $h_principiante = [];

    /* ALGORITMO GENETICO */
    /*Descripción del algoritmo
        1) Clasificar el personal, se generara un array del personal con valores 0(no apto) y 1(apto) si son aptos para los 3 dif. niveles: EJ. [0,1,1]
            En el ejemplo es apto para un nivel MEDIO y BASICO
        2) Generar la población inicial, según la variable de configuracion $cantidad_poblacion
        3) Ejecución del algoritmo, de la población generada se realizara una serie de pasos del algoritmo genetico:
            a) Obtener los mejores Padres, segun la variable de configuracion $mejores_padres, obtendrá esa cantidad de padres con mejores resultados
            b) Cruza, realizar un cruce aleatorio entre dos de los mejores padres
            c) Mutar Hijos, se utilizara un valor aleatorio para determinar si los hijos obtenidos deben mutar o no
                Para este caso se intercambiara el personal de cada cromosoma
            *) Formatear el resultado, este paso no es parte del algoritmo, se utilizará para ordenar y devolver un resultado que se pueda manejar para poder hacer la previsualización
    */
    public static function algoritmo($nivel_alto, $nivel_medio, $nivel_basico, $h_experto, $h_moderado, $h_intermedio, $h_principiante)
    {
        /* Configuración */
        $cantidad_población = 300;
        $cantidad_generaciones = 1000;
        $mejores_padres = 10;

        self::$nivel_basico = $nivel_basico;
        self::$nivel_medio = $nivel_medio;
        self::$nivel_alto = $nivel_alto;

        self::$h_experto = $h_experto;
        self::$h_moderado = $h_moderado;
        self::$h_intermedio = $h_intermedio;
        self::$h_principiante = $h_principiante;

        // CLASIFICA PERSONAL
        self::$personal_clasificado = self::getPersonalClasificado();
        // GENERACIÓN DE POBLACIÓN
        $poblacion = self::generaPoblacion($cantidad_población);
        // Ejecutar el algoritmo
        for ($i = 0; $i < $cantidad_generaciones; $i++) {
            // MEJORES PADRES
            $padres_seleccionados = self::getMejoresPadres($mejores_padres, $poblacion);
            // EJECUTA GENERACIONES
            $nuevos_hijos = self::Cruza($padres_seleccionados, $cantidad_población);
            $hijos_mutados = self::mutaHijos($nuevos_hijos);
            $poblacion = array_values(array_merge($padres_seleccionados, $hijos_mutados));
        }
        $mejor_resultado = $poblacion[0];
        return self::formateaResultado($mejor_resultado);
    }
    /* FIN ALGORITMO */

    /**
     * Recibe la poblacion generada y devuelve los mejores padres
     */
    public static function getMejoresPadres($n_padres, $poblacion)
    {
        $ordenado = $poblacion;
        rsort($ordenado);
        return array_slice($ordenado, 0, $n_padres);
    }

    /**
     * Recibe dos arrays padres, e intercambia su personal Guardias y Supervisores
     */
    public static function getCruzaPadres($padre1, $padre2)
    {
        $nuevo_hijo = $padre1;
        $total_indices = count($nuevo_hijo[1]);
        $media_indices = intdiv($total_indices, 2);
        for ($i = 0; $i < $media_indices; $i++) {
            $nuevo_hijo[1][$i][1]["guardias"] = $padre2[1][$i][1]["guardias"];
            $nuevo_hijo[1][$i][1]["supervisores"] = $padre2[1][$i][1]["supervisores"];
            $nuevo_hijo[0] = self::getPesoCromosoma($nuevo_hijo);
        }
        return $nuevo_hijo;
    }

    /**
     * Recibe el resultado obtenido del ALGORITMO y devuelve un resultado que se pueda manejar en la previsualización
     */
    public static function formateaResultado($value)
    {
        // SUPERVISORES
        $personal_existentes = [];
        foreach ($value[1] as $c) {
            foreach ($c[1]["supervisores"] as $key => $p) {
                $personal_existentes[] = $p;
            }
        }
        $repetidos = array_unique(array_diff_assoc($personal_existentes, array_unique($personal_existentes)));
        foreach ($value[1] as $key_c => $c) {
            foreach ($c[1]["supervisores"] as $key => $p) {
                if (in_array($p, $repetidos)) {
                    $verifica_personal = Personal::whereNotIn('id', $personal_existentes)->where('estado', 'ACTIVO')->where("tipo", "SUPERVISOR")->get();
                    foreach ($verifica_personal as $per) {
                        $puntuacion_habilidad = $per->puntuacion_habilidad;
                        $habilidad = $per->habilidad;
                        $valor_habilidad = self::getValorHabilidad($habilidad);
                        $aptitud = self::getAptitudPersonal($valor_habilidad, $puntuacion_habilidad);

                        if ($aptitud[0] == 1) {
                            $value[1][$key_c][1]["supervisores"][$key] = $per->id;
                            $personal_existentes[] = $per->id;
                            break;
                        } elseif ($c[0]->nivel == 'MEDIO') {
                            if ($aptitud[1] == 1) {
                                $value[1][$key_c][1]["supervisores"][$key] = $per->id;
                                $personal_existentes[] = $per->id;
                                break;
                            }
                        } elseif ($c[0]->nivel == 'BASICO') {
                            $value[1][$key_c][1]["supervisores"][$key] = $per->id;
                            $personal_existentes[] = $per->id;
                            break;
                        }
                    }
                }
            }
        }

        // GUARDIAS
        $personal_existentes = [];
        foreach ($value[1] as $c) {
            foreach ($c[1]["guardias"] as $key => $p) {
                $personal_existentes[] = $p;
            }
        }
        $repetidos = array_unique(array_diff_assoc($personal_existentes, array_unique($personal_existentes)));
        foreach ($value[1] as $key_c => $c) {
            foreach ($c[1]["guardias"] as $key => $p) {
                if (in_array($p, $repetidos)) {
                    $verifica_personal = Personal::whereNotIn('id', $personal_existentes)->where('estado', 'ACTIVO')->where("tipo", "GUARDIA")->get();
                    foreach ($verifica_personal as $per) {
                        $puntuacion_habilidad = $per->puntuacion_habilidad;
                        $habilidad = $per->habilidad;
                        $valor_habilidad = self::getValorHabilidad($habilidad);
                        $aptitud = self::getAptitudPersonal($valor_habilidad, $puntuacion_habilidad);

                        if ($aptitud[0] == 1) {
                            $value[1][$key_c][1]["guardias"][$key] = $per->id;
                            $personal_existentes[] = $per->id;
                            break;
                        } elseif ($c[0]->nivel == 'MEDIO') {
                            if ($aptitud[1] == 1) {
                                $value[1][$key_c][1]["guardias"][$key] = $per->id;
                                $personal_existentes[] = $per->id;
                                break;
                            }
                        } elseif ($c[0]->nivel == 'BASICO') {
                            $value[1][$key_c][1]["guardias"][$key] = $per->id;
                            $personal_existentes[] = $per->id;
                            break;
                        }
                    }
                }
            }
        }
        return $value;
    }

    /**
     * Recibe una lista de arrays(cromosomas) hijos
     * Utiliza un valor aleatorio entre 0 y 1 para determinar si habra o no una mutación
     * Si el valor aleatorio generado es mayor a 0.5, intercambiara un personal Supervisor y Guardia de cada uno de los hijos
     */
    public static function mutaHijos($hijos)
    {
        foreach ($hijos as $h) {
            $index1 = rand(0, count($h[1]) - 1);
            do {
                $index2 = rand(0, count($h[1]) - 1);
            } while ($index1 == $index2);
            $probabilidad_mutacion = rand(0, 100) / 100;
            if ($probabilidad_mutacion > 0.5) {
                // SUPERVISORES
                $cantidad_personal1 = count($h[1][$index1][1]["supervisores"]) - 1;
                $cantidad_personal2 = count($h[1][$index2][1]["supervisores"]) - 1;
                $cantidad_cambios = $cantidad_personal2;
                if ($cantidad_personal1 < $cantidad_personal2) {
                    $cantidad_cambios = $cantidad_personal1;
                }
                $index_cambio1 = rand(0, $cantidad_cambios);
                do {
                    $index_cambio2 = rand(0, $cantidad_cambios);
                } while ($index_cambio1 == $index_cambio2);
                $auxiliar = $h;
                $h[1][$index1][1]["supervisores"][$index_cambio1] = $h[1][$index2][1]["supervisores"][$index_cambio2];
                $h[1][$index2][1]["supervisores"][$index_cambio2] =  $auxiliar[1][$index1][1]["supervisores"][$index_cambio1];

                // GUARDIAS
                $cantidad_personal1 = count($h[1][$index1][1]["guardias"]) - 1;
                $cantidad_personal2 = count($h[1][$index2][1]["guardias"]) - 1;
                $cantidad_cambios = $cantidad_personal2;
                if ($cantidad_personal1 < $cantidad_personal2) {
                    $cantidad_cambios = $cantidad_personal1;
                }
                $index_cambio1 = rand(0, $cantidad_cambios);
                do {
                    $index_cambio2 = rand(0, $cantidad_cambios);
                } while ($index_cambio1 == $index_cambio2);
                $auxiliar = $h;
                $h[1][$index1][1]["guardias"][$index_cambio1] = $h[1][$index2][1]["guardias"][$index_cambio2];
                $h[1][$index2][1]["guardias"][$index_cambio2] =  $auxiliar[1][$index1][1]["guardias"][$index_cambio1];

                $h[0] = self::getPesoCromosoma($h);
                // $h = self::formateaResultado($h);
            }
        }
        return $hijos;
    }

    /**
     * Recibe los mejores padres de cada Generación y la poblacion total
     * Calcula los hijos faltantes
     * Obtiene la cantidad de padres(indices totales que se manejaran)
     * Genera dos indices aleatorios segun la cantidad de padres
     * Cruza los dos padres seleccionados de acuerdo a los indices generados
     * Devuelve los hijos generados
     */
    public static function Cruza($mejores_padres, $n_poblacion)
    {
        $hijos_faltantes = $n_poblacion - count($mejores_padres);
        $nuevos_hijos = [];
        $indice_p1 = 0;
        $indice_p2 = 0;
        $total_indices = count($mejores_padres) - 1;

        for ($i = 0; $i < $hijos_faltantes; $i++) {
            $indice_p1 = rand(0, $total_indices);
            do {
                $indice_p2 = rand(0, $total_indices);
            } while ($indice_p1 == $indice_p2);
            $nuevo_hijo = self::getCruzaPadres($mejores_padres[$indice_p1], $mejores_padres[$indice_p2]);
            $nuevos_hijos[] = $nuevo_hijo;
        }
        return $nuevos_hijos;
    }

    /**
     * Recibe un cromosoma
     * Recorre el personal que se encuentra en el Cromosoma (GUARDIAS y SUPERVISORES)
     * Suma el valor de APTITUD generado inicialmente al Clasificar el Personal
     * Cuenta el total de personal asignado con un contador para posteriormente sacar una media
     * Devuelve el peso total obtenido de la Sumatoria
     */
    public static function getPesoCromosoma($cromosoma)
    {
        // DEACUERDO AL NIVEL DEL PUESTO DE VIGILANCIA
        // REALIZAR LA SUMATORIA/N DE ACUERDO A LA CLASIFICACIÓN DEL PERSONAL
        $contador = 0;
        $sumatoria = 0;
        foreach ($cromosoma[1] as $c) {
            // recorrer el personal
            switch ($c[0]->nivel) {
                case 'ALTO':
                    foreach ($c[1]["guardias"] as $per) {
                        $res = self::$personal_clasificado[$per][0];
                        $sumatoria += $res;
                        $contador++;
                    }
                    foreach ($c[1]["supervisores"] as $per) {
                        $res = self::$personal_clasificado[$per][0];
                        $sumatoria += $res;
                        $contador++;
                    }
                    break;
                case 'MEDIO':
                    foreach ($c[1]["guardias"] as $per) {
                        $res = self::$personal_clasificado[$per][1];
                        $sumatoria += $res;
                        $contador++;
                    }
                    foreach ($c[1]["supervisores"] as $per) {
                        $res = self::$personal_clasificado[$per][1];
                        $sumatoria += $res;
                        $contador++;
                    }
                    break;
                case 'BASICO':
                    foreach ($c[1]["guardias"] as $per) {
                        $res = self::$personal_clasificado[$per][2];
                        $sumatoria += $res;
                        $contador++;
                    }
                    foreach ($c[1]["supervisores"] as $per) {
                        $res = self::$personal_clasificado[$per][2];
                        $sumatoria += $res;
                        $contador++;
                    }
                    break;
            }
        }

        $resultado_peso = ($sumatoria / $contador);
        return (float)(number_format($resultado_peso, 2, '.', ''));
    }


    /**
     * Función para determinar las aptitudes de cada PERSONAL para cada puesto de vigilancia de NIVEL:Alto,Medio,Basico
     * Ej.: (ID) 1 |(Nombre)Juan Perez | (Habilidad)Experto | (Nivel)Alto
     * Se determinara su aptitud mediante un array que tendra el sgte. formato [PERSONAL(ID), PuedeNivelAlto, PuedeNivelMedio, PuedeNivelBajo]
     * Si se determina que puede un Nivel tomara el valor 1 caso contrario 0
     * Para determinar dicho valor clasificando cada nivel deacuerdo a los parametros recibidos por HABILIDAD(minimo y maximo), generando un valor aletario dentro de estos rangos
     * Donde cada nivel del personal se clasificara con los sgtes. valores: ALTO=1; MEDIO=0.8 ; BAJO = 0.5
     * Por tanto con un parametro $h_experto(habilidad experto) = [13,15], generando un aleatorio = 13, con un nivel ALTO => Aptitud= ((13/13[minimo]) + (13/15[maximo]) + (95[puntuacion_habilidad] / 100))/3
     * Dando como resultado = 0.92
     * Para clasificar su aptitud en cada nivel se debe repetir este proceso para cada uno de los niveles, utilizando el valor obtenido y dividiendolo por el minimo y maximo de cada habilidad obtenida como parametro
     * Para que el personal sea apto se utilizaran los sgtes. valores:
     * a) Aptitud Alto,medio y basico: 0.9+ (resultado_experto) | 1+ (resultado_moderado)
     * b) Aptitud medio y basico: 0.65+ (resultado_intermedio) | 0.8+ (resultado_moderado)
     * c) Aptitud basico, no cumplir las anteriores condiciones
     * @return array
     */
    public static function getPersonalClasificado()
    {
        $personals = Personal::where('estado', 'ACTIVO')->get();
        $array_personal = [];
        foreach ($personals as $personal) {
            $habilidad = $personal->habilidad;
            $puntuacion_habilidad = $personal->puntuacion_habilidad;
            $valor_habilidad = self::getValorHabilidad($habilidad);
            $array_personal[$personal->id] = self::getAptitudPersonal($valor_habilidad, $puntuacion_habilidad);
        }
        return $array_personal;
    }

    /**
     * Recibe la cantidad de población que se desea generar
     * Deacuerdo a la cantidad de Supervisores y Guardias(Maximo y minimo), se obtendra valores aleatorios segun estos parametros
     * Una vez obtenidos estos valores se tomara una cantidad de personal(aleatoriamente) para cada Puesto de Vigilancia (Supervisores y Guardias)
     * Al final devolvera la población inicial
     */
    public static function generaPoblacion($n_poblacion)
    {
        $poblacion = [];
        $copy_array_personal_guardias = [];
        $array_personal_guardias = [];
        $array_personal_supervisores = [];
        $copy_array_personal_supervisores = [];
        $puesto_vigilancias = PuestoVigilancia::where('estado', 'ACTIVO')->get();
        // GUARDIAS
        $personal_guardias = Personal::select('id')->where('estado', 'ACTIVO')->where("tipo", "GUARDIA")->get();
        foreach ($personal_guardias as $p) {
            $array_personal_guardias[] = $p->id;
        }
        // SUPERVISORES
        $personal_supervisores = Personal::select('id')->where('estado', 'ACTIVO')->where("tipo", "SUPERVISOR")->get();
        foreach ($personal_supervisores as $p) {
            $array_personal_supervisores[] = $p->id;
        }

        $personal_restante_guardias = 0;
        $personal_restante_supervisores = 0;
        for ($i = 1; $i <= $n_poblacion; $i++) {
            $copy_array_personal_guardias = $array_personal_guardias; //copiar el array del personal
            shuffle($copy_array_personal_guardias); //ordenar aleatoriamente el array con los IDs del personal
            $copy_array_personal_supervisores = $array_personal_supervisores;
            shuffle($copy_array_personal_supervisores);
            $cromosoma = [0, []]; //nuevo cromosoma
            foreach ($puesto_vigilancias as $puesto) {
                $personal_restante_guardias = count($copy_array_personal_guardias);
                $personal_restante_supervisores = count($copy_array_personal_supervisores);
                // RELLENAR GUARDIAS Y SUPERVISORES
                $generacion = [$puesto, ["guardias" => [], "supervisores" => []]];
                if ($personal_restante_guardias > 0) {
                    // asignar una cantidad random de personal deacuerdo al Nivel y parametros recibidos de cantidad de personal min y max
                    $guardia_minimo = 0;
                    $guardia_maximo = 0;
                    $cantidad_personal_tomar = 0;
                    if ($puesto->nivel == "ALTO") {
                        $guardia_minimo = self::$nivel_alto['guardia_min'];
                        $guardia_maximo = self::$nivel_alto['guardia_max'];
                    } elseif ($puesto->nivel == "MEDIO") {
                        $guardia_minimo = self::$nivel_medio['guardia_min'];
                        $guardia_maximo = self::$nivel_medio['guardia_max'];
                    } elseif ($puesto->nivel == "BASICO") {
                        $guardia_minimo = self::$nivel_basico['guardia_min'];
                        $guardia_maximo = self::$nivel_basico['guardia_max'];
                    }
                    $cantidad_personal_tomar = rand($guardia_minimo, $guardia_maximo); //generar un valor aleatorio deacuerdo al min, y max de personal permitido
                    if ($personal_restante_guardias > $cantidad_personal_tomar) {
                        // if ($cantidad_personal_tomar > $puesto->personal) {
                        //     $cantidad_personal_tomar = $puesto->personal;
                        // }
                        $index_random = rand(0, $personal_restante_guardias - $cantidad_personal_tomar - 1); //tomar un index menor a la cantidad de personal que se requiere
                    } else {
                        $cantidad_personal_tomar = $personal_restante_guardias;
                        $index_random = 0; //tomar un index menor a la cantidad de personal que se requiere
                    }
                    // \Log::debug('personal_restante_guardias::' . $personal_restante_guardias);
                    // \Log::debug('cantidad_personal_tomar::' . $cantidad_personal_tomar);
                    // \Log::debug('index::' . $index_random);
                    $personal_usado = [];
                    // guardias
                    for ($j = $index_random; $j < $index_random + $cantidad_personal_tomar; $j++) {
                        $generacion[1]["guardias"][] = $copy_array_personal_guardias[$j];
                        $personal_usado[] = $j;
                    }
                    // desecha al personal ya utilizado
                    foreach ($personal_usado as $usado) {
                        unset($copy_array_personal_guardias[$usado]); //eliminar los valores usados
                    }
                    $copy_array_personal_guardias = array_values($copy_array_personal_guardias); //restablecer index
                }
                if ($personal_restante_supervisores > 0) {
                    // asignar una cantidad random de personal deacuerdo al Nivel y parametros recibidos de cantidad de personal min y max
                    $supervisor_minimo = 0;
                    $cantidad_personal_tomar = 0;
                    if ($puesto->nivel == "ALTO") {
                        $supervisor_minimo = self::$nivel_alto['supervisor_min'];
                    } elseif ($puesto->nivel == "MEDIO") {
                        $supervisor_minimo = self::$nivel_medio['supervisor_min'];
                    } elseif ($puesto->nivel == "BASICO") {
                        $supervisor_minimo = self::$nivel_basico['supervisor_min'];
                    }
                    $cantidad_personal_tomar = $supervisor_minimo;
                    if ($personal_restante_supervisores > $cantidad_personal_tomar) {
                        $index_random = rand(0, $personal_restante_supervisores - $cantidad_personal_tomar - 1); //tomar un index menor a la cantidad de personal que se requiere
                    } else {
                        $cantidad_personal_tomar = $personal_restante_supervisores;
                        $index_random = 0; //tomar un index menor a la cantidad de personal que se requiere
                    }
                    // \Log::debug('personal_restante_supervisores::' . $personal_restante_supervisores);
                    // \Log::debug('cantidad_personal_tomar::' . $cantidad_personal_tomar);
                    // \Log::debug('index::' . $index_random);
                    $personal_usado = [];
                    // supervisores
                    for ($j = $index_random; $j < $index_random + $cantidad_personal_tomar; $j++) {
                        $generacion[1]["supervisores"][] = $copy_array_personal_supervisores[$j];
                        $personal_usado[] = $j;
                    }
                    // desecha al personal ya utilizado
                    foreach ($personal_usado as $usado) {
                        unset($copy_array_personal_supervisores[$usado]); //eliminar los valores usados
                    }
                    $copy_array_personal_supervisores = array_values($copy_array_personal_supervisores); //restablecer index
                }

                $cromosoma[1][] = $generacion;
                // return $cromosoma;
            }
            //OBTENER EL PESO DEL CROMOSOMA
            $cromosoma[0] = self::getPesoCromosoma($cromosoma);
            $poblacion[] = $cromosoma;
        }
        return $poblacion;
    }


    // FUNCION PARA DETERMINA LA APTITUD DEL PERSONAL
    public static function getAptitudPersonal($valor_habilidad, $puntuacion_habilidad)
    {
        // por defecto el personal tendra aptitud para un nivel Básico
        $aptitud = [0, 0, 1]; // [ALTO, MEDIO, BAJO]  | 0 = Sin aptutid; 1 = Con aptitud
        // NIVEL ALTO
        $resultado_experto = (($valor_habilidad / self::$h_experto['min']) + ($valor_habilidad / self::$h_experto['max']) + ($puntuacion_habilidad / 100)) / 3; //experto
        $resultado_moderado = (($valor_habilidad / self::$h_moderado['min']) + ($valor_habilidad / self::$h_moderado['max']) + ($puntuacion_habilidad / 100)) / 3; //moderado
        $resultado_intermedio = (($valor_habilidad / self::$h_intermedio['min']) + ($valor_habilidad / self::$h_intermedio['max']) + ($puntuacion_habilidad / 100)) / 3; //intermedio
        $resultado_principiante = (($valor_habilidad / self::$h_principiante['min']) + ($valor_habilidad / self::$h_principiante['max']) + ($puntuacion_habilidad / 100)) / 3; //principiante
        \Log::debug('--------------------------------------------------------');
        \Log::debug('puntuacion_habilidad::' . $puntuacion_habilidad);
        \Log::debug('EXPERTO::' . $resultado_experto);
        \Log::debug('MODERADO::' . $resultado_moderado);
        \Log::debug('INTERMEDIO::' . $resultado_intermedio);
        \Log::debug('PRINCIPIANTE::' . $resultado_principiante);

        // Si es apto para un nivel alto por ende sera apto para los demas niveles
        if ($resultado_experto >= 0.9 || $resultado_moderado >= 1) {
            $aptitud[0] = 1;
            $aptitud[1] = 1;
            $aptitud[2] = 1;
        } elseif ($resultado_intermedio >= 0.65 || $resultado_moderado >= 0.8) {
            $aptitud[0] = 0;
            $aptitud[1] = 1;
            $aptitud[2] = 1;
        } elseif ($resultado_principiante > 0) {
            $aptitud[0] = 0;
            $aptitud[1] = 0;
            $aptitud[2] = 1;
        }

        return $aptitud;
    }

    /**
     * Deacuerdo a la habilidad de cada personal devolvera un valor aleatorio que se cuentra en el rango de los dos valores maximo y minimo enviados desde el formulario
     */
    public static function getValorHabilidad($habilidad)
    {
        $min = 0;
        $max = 0;
        switch ($habilidad) {
            case 'EXPERTO':
                $min = self::$h_experto['min'];
                $max = self::$h_experto['max'];
                break;
            case 'MODERADO':
                $min = self::$h_moderado['min'];
                $max = self::$h_moderado['max'];
                break;
            case 'INTERMEDIO':
                $min = self::$h_intermedio['min'];
                $max = self::$h_intermedio['max'];
                break;
            case 'PRINCIPIANTE':
                $min = self::$h_principiante['min'];
                $max = self::$h_principiante['max'];
                break;
        }
        return rand($min, $max);
    }
}
