<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'puesto_vigilancia_id', 'fecha_registro',
    ];

    protected $with = ["puesto_vigilancia", "asignacion_personals.personal"];

    public static $personal_clasificado = [];
    public static $nivel_basico = [];
    public static $nivel_medio = [];
    public static $nivel_alto = [];

    public static $h_experto = [];
    public static $h_moderado = [];
    public static $h_intermedio = [];
    public static $h_principiante = [];


    //RELACIONES
    public function asignacion_personals()
    {
        return $this->hasMany(AsignacionPersonal::class, 'asignacion_id');
    }

    public function puesto_vigilancia()
    {
        return $this->belongsTo(PuestoVigilancia::class, 'puesto_vigilancia_id');
    }

    /* ALGORITMO GENETICO */
    public static function algoritmo($nivel_alto, $nivel_medio, $nivel_basico, $h_experto, $h_moderado, $h_intermedio, $h_principiante)
    {
        /* Configuración */
        $cantidad_población = 100;
        $cantidad_generaciones = 250; //despues de varias pruebas en 250 generaciones el algoritmo arroja un resultado optimo de 0.9 de 1
        /* Fin configuración */

        self::$nivel_basico = $nivel_basico;
        self::$nivel_medio = $nivel_medio;
        self::$nivel_alto = $nivel_alto;

        self::$h_experto = $h_experto;
        self::$h_moderado = $h_moderado;
        self::$h_intermedio = $h_intermedio;
        self::$h_principiante = $h_principiante;

        // CLASIFICA PERSONAL
        self::$personal_clasificado = Asignacion::getPersonalClasificado();
        // GENERACIÓN DE POBLACIÓN
        $poblacion = Asignacion::generaPoblacion($cantidad_población);

        for ($i = 0; $i < $cantidad_generaciones; $i++) {
            // MEJORES PADRES
            $padres_seleccionados = Asignacion::getMejoresPadres(10, $poblacion);
            // EJECUTA GENERACIONES
            $nuevos_hijos = self::Cruza($padres_seleccionados, $cantidad_población);
            $hijos_mutados = self::mutaHijos($nuevos_hijos);
            $hijos_mutados;
            $poblacion = array_values(array_merge($padres_seleccionados, $hijos_mutados));
        }
        $mejor_resultado = $poblacion[0];
        return self::formateaResultado($mejor_resultado);
    }


    //funcion para obtener los mejores padres
    public static function getMejoresPadres($n_padres, $poblacion)
    {
        $ordenado = $poblacion;
        rsort($ordenado);
        return array_slice($ordenado, 0, $n_padres);
    }

    //funcion para generar cruzar dos padres
    public static function getCruzaPadres($padre1, $padre2)
    {
        $nuevo_hijo = $padre1;
        $total_indices = count($nuevo_hijo[1]);
        $media_indices = intdiv($total_indices, 2);
        // recorrer los indices e intercambiar el personal de cada cromosoma
        for ($i = 0; $i < $media_indices; $i++) {
            $nuevo_hijo[1][$i][1] = $padre2[1][$i][1];
            $nuevo_hijo[0] = self::getPesoCromosoma($nuevo_hijo);
        }
        return $nuevo_hijo;
    }

    // BUSCAR PERSONAL REPETIDO
    public static function formateaResultado($value)
    {
        $personal_existentes = [];
        foreach ($value[1] as $c) {
            foreach ($c[1] as $key => $p) {
                $personal_existentes[] = $p;
            }
        }
        $repetidos = array_unique(array_diff_assoc($personal_existentes, array_unique($personal_existentes)));
        foreach ($value[1] as $key_c => $c) {
            foreach ($c[1] as $key => $p) {
                if (in_array($p, $repetidos)) {
                    $verifica_personal = Personal::whereNotIn('id', $personal_existentes)->where('estado', 'ACTIVO')->get();
                    foreach ($verifica_personal as $per) {
                        $habilidad = $per->habilidad;
                        $nivel = $per->nivel;
                        $valor_habilidad = self::getValorHabilidad($habilidad);
                        $valor_nivel = self::getValorNivel($nivel);
                        $aptitud = self::getAptitudPersonal($valor_habilidad, $valor_nivel);

                        if ($aptitud[0] == 1) {
                            $value[1][$key_c][1][$key] = $per->id;
                            $personal_existentes[] = $per->id;
                            break;
                        } elseif ($c[0]->nivel == 'MEDIO') {
                            if ($aptitud[1] == 1) {
                                $value[1][$key_c][1][$key] = $per->id;
                                $personal_existentes[] = $per->id;
                                break;
                            }
                        } elseif ($c[0]->nivel == 'BASICO') {
                            $value[1][$key_c][1][$key] = $per->id;
                            $personal_existentes[] = $per->id;
                            break;
                        }
                    }
                }
            }
        }
        return $value;
    }

    public static function mutaHijos($hijos)
    {
        // para la mutación se intercambiara el un personal de todos los puestos
        foreach ($hijos as $h) {
            $index1 = rand(0, count($h[1]) - 1);
            do {
                $index2 = rand(0, count($h[1]) - 1);
            } while ($index1 == $index2);
            // generar un numero random para porcentaje
            $probabilidad_mutacion = rand(0, 100) / 100;
            if ($probabilidad_mutacion > 0.5) {
                // mutar valores de personal
                $cantidad_personal1 = count($h[1][$index1][1]) - 1;
                $cantidad_personal2 = count($h[1][$index2][1]) - 1;
                $cantidad_cambios = $cantidad_personal2;
                if ($cantidad_personal1 < $cantidad_personal2) {
                    $cantidad_cambios = $cantidad_personal1;
                }
                $index_cambio1 = rand(0, $cantidad_cambios);
                do {
                    $index_cambio2 = rand(0, $cantidad_cambios);
                } while ($index_cambio1 == $index_cambio2);
                $auxiliar = $h;
                $h[1][$index1][1][$index_cambio1] = $h[1][$index2][1][$index_cambio2];
                $h[1][$index2][1][$index_cambio2] =  $auxiliar[1][$index1][1][$index_cambio1];
                $h[0] = self::getPesoCromosoma($h);
                // $h = self::formateaResultado($h);
            }
        }
        return $hijos;
    }

    // funcion para aplicar el cruce de los padres
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

    //funcion para mutar los hijos
    public static function getHijosMutados()
    {
    }

    //funcion para determinar el peso de cada cromosoma
    //tomando en cuenta que el mayor peso es el mejor que ira desde 0 hasta 1
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
                    foreach ($c[1] as $per) {
                        $res = self::$personal_clasificado[$per][0];
                        $sumatoria += $res;
                        $contador++;
                    }
                    break;
                case 'MEDIO':
                    foreach ($c[1] as $per) {
                        $res = self::$personal_clasificado[$per][1];
                        $sumatoria += $res;
                        $contador++;
                    }
                    break;
                case 'BASICO':
                    foreach ($c[1] as $per) {
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
     * Por tanto con un parametro $h_experto = [13,15], generando un aleatorio = 13, con un nivel ALTO => Aptitud= ((13/13[minimo]) + (13/15[maximo])/2) * 1[ALTO]
     * Dando como resultado = 0.9
     * Para clasificar su aptitud en cada nivel se debe repetir este proceso para cada uno de los niveles, utilizando el valor obtenido y dividiendolo por el minimo y maximo de cada habilidad obtenida como parametro
     * Para que el personal sea apto debe superar un resultado como minimo de 0.7
     * @return array
     */
    public static function getPersonalClasificado()
    {
        $personals = Personal::where('estado', 'ACTIVO')->get();
        $array_personal = [];
        foreach ($personals as $personal) {
            $habilidad = $personal->habilidad;
            $nivel = $personal->nivel;
            $valor_habilidad = self::getValorHabilidad($habilidad);
            $valor_nivel = self::getValorNivel($nivel);
            $array_personal[$personal->id] = self::getAptitudPersonal($valor_habilidad, $valor_nivel);
        }
        return $array_personal;
    }

    // funcion para obtener la poblacion inicial
    public static function generaPoblacion($n_poblacion)
    {
        $poblacion = [];
        $array_personal = [];
        $personals = Personal::select('id')->where('estado', 'ACTIVO')->get();
        foreach ($personals as $p) {
            $array_personal[] = $p->id;
        }
        $puesto_vigilancias = PuestoVigilancia::where('estado', 'ACTIVO')->get();
        // generar la poblacino deacuerdo a la cantidad recibida
        $personal_restante = 0;
        for ($i = 1; $i <= $n_poblacion; $i++) {
            $copy_array_personal = $array_personal; //copiar el array del personal
            shuffle($copy_array_personal); //ordenar aleatoriamente el array con los IDs del personal
            $cromosoma = [0, []]; //nuevo cromosoma
            foreach ($puesto_vigilancias as $puesto) {
                $personal_restante = count($copy_array_personal);
                if ($personal_restante > 0) {
                    // asignar una cantidad random de personal deacuerdo al Nivel y parametros recibidos de cantidad de personal min y max
                    $personal_minimo = 0;
                    $personal_maximo = 0;
                    $cantidad_personal_tomar = 0;
                    if ($puesto->personal <= self::$nivel_basico['personal_max']) {
                        $puesto->nivel = 'BASICO';
                        $personal_minimo = self::$nivel_basico['personal_min'];
                        $personal_maximo = self::$nivel_basico['personal_max'];
                    } elseif ($puesto->personal >= self::$nivel_medio['personal_min'] && $puesto->personal <= self::$nivel_medio['personal_max']) {
                        $puesto->nivel = 'MEDIO';
                        $personal_minimo = self::$nivel_medio['personal_min'];
                        $personal_maximo = self::$nivel_medio['personal_max'];
                    } elseif ($puesto->personal >= self::$nivel_alto['personal_min']) {
                        $puesto->nivel = 'ALTO';
                        $personal_minimo = self::$nivel_alto['personal_min'];
                        $personal_maximo = self::$nivel_alto['personal_max'];
                    }
                    $cantidad_personal_tomar = rand($personal_minimo, $personal_maximo); //generar un valor aleatorio deacuerdo al min, y max de personal permitido
                    if ($personal_restante > $cantidad_personal_tomar) {
                        if ($cantidad_personal_tomar > $puesto->personal) {
                            $cantidad_personal_tomar = $puesto->personal;
                        }
                        $index_random = rand(0, $personal_restante - $cantidad_personal_tomar - 1); //tomar un index menor a la cantidad de personal que se requiere
                    } else {
                        $cantidad_personal_tomar = $personal_restante;
                        $index_random = 0; //tomar un index menor a la cantidad de personal que se requiere
                    }
                    // \Log::debug('personal_restante::' . $personal_restante);
                    // \Log::debug('cantidad_personal_tomar::' . $cantidad_personal_tomar);
                    // \Log::debug('index::' . $index_random);
                    $personal_usado = [];
                    $gen = [$puesto, []];
                    for ($j = $index_random; $j < $index_random + $cantidad_personal_tomar; $j++) {
                        $gen[1][] = $copy_array_personal[$j];
                        $personal_usado[] = $j;
                    }
                    $cromosoma[1][] = $gen;
                    // desecha al personal ya utilizado
                    foreach ($personal_usado as $usado) {
                        unset($copy_array_personal[$usado]); //eliminar los valores usados
                    }
                    $copy_array_personal = array_values($copy_array_personal); //restablecer index
                }
            }
            //OBTENER EL PESO DEL CROMOSOMA
            $cromosoma[0] = self::getPesoCromosoma($cromosoma);
            $poblacion[] = $cromosoma;
        }

        return $poblacion;
    }


    // FUNCION PARA DETERMINA LA APTITUD DEL PERSONAL
    public static function getAptitudPersonal($valor_habilidad, $valor_nivel)
    {
        // por defecto el personal tendra aptitud para un nivel Básico
        $aptitud = [0, 0, 1]; // [ALTO, MEDIO, BAJO]  | 0 = Sin aptutid; 1 = Con aptitud
        // NIVEL ALTO
        $resultado_experto = (($valor_habilidad / self::$h_experto['min']) + ($valor_habilidad / self::$h_experto['max']) / 2) * $valor_nivel; //experto
        $resultado_moderado = (($valor_habilidad / self::$h_moderado['min']) + ($valor_habilidad / self::$h_moderado['max']) / 2) * $valor_nivel; //moderado
        $resultado_intermedio = (($valor_habilidad / self::$h_intermedio['min']) + ($valor_habilidad / self::$h_intermedio['max']) / 2) * $valor_nivel; //intermedio
        $resultado_principiante = (($valor_habilidad / self::$h_principiante['min']) + ($valor_habilidad / self::$h_principiante['max']) / 2) * $valor_nivel; //principiante

        if ($resultado_experto > 0.7 || $resultado_moderado > 0.7) {
            // Si es apto para un nivel alto por ende sera apto para los demas niveles
            $aptitud[0] = 1;
            $aptitud[1] = 1;
            $aptitud[2] = 1;
        } elseif ($resultado_intermedio > 0.7) {
            $aptitud[0] = 0;
            $aptitud[1] = 1;
            $aptitud[2] = 1;
        } elseif ($resultado_principiante > 0.7) {
            $aptitud[0] = 0;
            $aptitud[1] = 0;
            $aptitud[2] = 1;
        }

        return $aptitud;
    }

    // FUNCION PARA OBTENER EL VALOR ALEATORIO DE HABILIDAD DEL PERSONAL
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

    //FUNCION PARA OBTENER EL VALOR DEACUERDO AL NIVEL DEL PERSONAL
    public static function getValorNivel($nivel)
    {
        switch ($nivel) {
            case 'ALTO':
                return 1;
            case 'MEDIO':
                return 0.8;
            case 'BAJO':
                return 0.5;
        }
    }
}
