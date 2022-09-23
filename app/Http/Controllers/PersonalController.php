<?php

namespace App\Http\Controllers;

use App\Models\AsignacionPersonal;
use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public $validacion = [
        'nombre' => 'required|min:4',
        'paterno' => 'required|min:4',
        'materno' => 'nullable|min:4',
        'ci' => 'required|numeric|digits_between:4, 20|unique:personals,ci',
        'ci_exp' => 'required',
        'fecha_nacimiento' => 'required|date',
        'estatura' => 'required|numeric:min:1',
        'peso' => 'required|numeric|min:40',
        'nacionalidad' => 'required|min:4',
        'dir' => 'required|min:4',
        'correo' => 'required|email',
        'fono' => 'required|min:4',
        'cel' => 'required|min:4',
        'tipo' => 'required',
        'habilidad' => 'required',
        'nivel' => 'required',
        'estado' => 'required',
    ];

    public $mensajes = [
        'nombre.required' => 'Este campo es obligatorio',
        'nombre.min' => 'Debes ingressar al menos 4 carácteres',
        'paterno.required' => 'Este campo es obligatorio',
        'paterno.min' => 'Debes ingresar al menos 4 carácteres',
        'ci.required' => 'Este campo es obligatorio',
        'ci.numeric' => 'Debes ingresar un valor númerico',
        'ci.unique' => 'Este número de C.I. ya fue registrado',
        'ci_exp.required' => 'Este campo es obligatorio',
        'dir.required' => 'Este campo es obligatorio',
        'dir.min' => 'Debes ingresar al menos 4 carácteres',
        'fono.required' => 'Este campo es obligatorio',
        'fono.min' => 'Debes ingresar al menos 4 carácteres',
        'cel.required' => 'Este campo es obligatorio',
        'cel.min' => 'Debes ingresar al menos 4 carácteres',
        'tipo.required' => 'Este campo es obligatorio',
        'correo' => 'nullable|email|unique:personals,correo',
    ];

    public function index(Request $request)
    {
        $personals = Personal::all();
        return response()->JSON(['personals' => $personals, 'total' => count($personals)], 200);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpg,jpeg,png|max:2048';
        }
        $request->validate($this->validacion, $this->mensajes);
        // CREAR EL PERSONSAL
        $request['fecha_registro'] = date("Y-m-d");
        $nuevo_personal = Personal::create(array_map('mb_strtoupper', $request->except('foto')));
        $nuevo_personal->save();
        $nuevo_personal->foto = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->foto;
            $nom_foto = time() . '_' . str_replace(" ", "_", $nuevo_personal->full_name) . '.' . $file->getClientOriginalExtension();
            $nuevo_personal->foto = $nom_foto;
            $file->move(public_path() . '/imgs/personal/', $nom_foto);
        }
        $nuevo_personal->correo = mb_strtolower($nuevo_personal->correo);
        $nuevo_personal->save();
        return response()->JSON([
            'sw' => true,
            'personal' => $nuevo_personal,
            'msj' => 'El registro se realizó de forma correcta',
        ], 200);
    }

    public function update(Request $request, Personal $personal)
    {
        $this->validacion['ci'] = 'required|min:4|numeric|unique:personals,ci,' . $personal->id;
        $this->validacion['correo'] = 'required|email|unique:personals,correo,' . $personal->id;
        if ($request->hasFile('foto')) {
            $this->validacion['foto'] = 'image|mimes:jpg,jpeg,png|max:2048';
        }

        $request->validate($this->validacion, $this->mensajes);

        $personal->update(array_map('mb_strtoupper', $request->except('foto')));
        if ($personal->correo == "") {
            $personal->correo = NULL;
        }

        if ($request->hasFile('foto')) {
            $antiguo = $personal->foto;
            if ($antiguo != 'default.png') {
                \File::delete(public_path() . '/imgs/personal/' . $antiguo);
            }
            $file = $request->foto;
            $nom_foto = time() . '_' . $personal->personal . '.' . $file->getClientOriginalExtension();
            $personal->foto = $nom_foto;
            $file->move(public_path() . '/imgs/personal/', $nom_foto);
        }
        $personal->correo = mb_strtolower($personal->correo);
        $personal->save();
        return response()->JSON([
            'sw' => true,
            'personal' => $personal,
            'msj' => 'El registro se actualizó de forma correcta'
        ], 200);
    }

    public function show(Personal $personal)
    {
        return response()->JSON([
            'sw' => true,
            'personal' => $personal
        ], 200);
    }

    public function destroy(Personal $personal)
    {
        $existe_asignacion = AsignacionPersonal::where('personal_id', $personal->id)->get()->first();
        if ($existe_asignacion) {
            return response()->JSON([
                'sw' => false,
                'msj' => 'El registro no se puede eliminar, porque esta siendo utilizado en una asignación'
            ], 200);
        }
        $antiguo = $personal->foto;
        if ($antiguo != 'default.png') {
            \File::delete(public_path() . '/imgs/personal/' . $antiguo);
        }
        $personal->delete();
        return response()->JSON([
            'sw' => true,
            'msj' => 'El registro se eliminó correctamente'
        ], 200);
    }
}
