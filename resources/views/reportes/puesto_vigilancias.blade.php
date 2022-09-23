<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PuestosVigilancias</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 2cm;
            margin-bottom: 1cm;
            margin-left: 1.5cm;
            margin-right: 1cm;
            border: 5px solid blue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 20px;
        }

        table thead tr th,
        tbody tr td {
            font-size: 0.63em;
            word-wrap: break-word;
            padding: 3px;
        }

        table thead {
            background: rgb(236, 236, 236)
        }


        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            width: 200px;
            height: 90px;
            top: -20px;
            left: -20px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 15px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14pt;
        }

        .texto {
            width: 600px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1em;
        }

        .fecha {
            width: 400px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: normal;
            font-size: 0.85em;
        }

        .total {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }

        .centreado {
            padding-left: 0px;
            text-align: center;
        }

        .datos {
            margin-left: 15px;
            border-top: solid 1px;
            border-collapse: collapse;
            width: 250px;
        }

        .txt {
            font-weight: bold;
            text-align: right;
            padding-right: 5px;
        }

        .txt_center {
            font-weight: bold;
            text-align: center;
        }

        .cumplimiento {
            position: absolute;
            width: 150px;
            right: 0px;
            top: 86px;
        }

        .p_cump {
            color: red;
            font-size: 1.2em;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(236, 236, 236)
        }

        .img_celda img {
            width: 45px;
        }
    </style>
</head>

<body>
    @inject('configuracion', 'App\Models\Configuracion')
    <div class="encabezado">
        <div class="logo">
            <img src="{{ asset('imgs/' . $configuracion->first()->logo) }}">
        </div>
        <h2 class="titulo">
            {{ $configuracion->first()->razon_social }}
        </h2>
        <h4 class="texto">PUESTOS DE VIGILANCIA </h4>
        <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
    </div>

    @foreach ($puesto_vigilancias as $puesto_vigilancia)
        <table border="1">
            <thead>
                <tr>
                    <th colspan="2">{{ $puesto_vigilancia->nombre }}</th>
                </tr>
                <tr>
                    <th>Lista de Personal</th>
                    <th>Lista de Materiales</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if ($puesto_vigilancia->asignacion)
                            <ol>
                                @foreach ($puesto_vigilancia->asignacion->asignacion_personals as $ap)
                                    <li>{{ $ap->personal->full_name }} <small>({{$ap->personal->tipo}})</small></li>
                                @endforeach
                            </ol>
                        @endif
                    </td>
                    <td>
                        @if (count($puesto_vigilancia->materials) > 0)
                            <ol>
                                @foreach ($puesto_vigilancia->materials as $m)
                                    <li>{{ $m->nombre }}</li>
                                @endforeach
                            </ol>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
</body>

</html>
