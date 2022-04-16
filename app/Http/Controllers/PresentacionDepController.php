<?php

namespace App\Http\Controllers;

use App\PresentacionDep;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PresentacionDepController extends Controller
{

    public function index()
    {
        $presentacion_dep = PresentacionDep::all();
        return $this->successResponse($presentacion_dep);
    }

    public function show($presentacion_dep)
    {
        $presentacion_dep = PresentacionDep::findOrFail($presentacion_dep);
        return $this->successResponse($presentacion_dep);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'titulo' => 'required|max:120',
            'descripcion' => 'required|max:255',
            'deporte' => 'required|max:120',
            'lugar' => 'required|max:120',
            'fecha' => 'max:255',
        ];
        $this->validate($request, $rules);

        if ($request->hasFile('img')) {
            $image      = $request->file('img');
            $destination = "images/";
            $fileName   = time() . '.' . $image->getClientOriginalExtension();
            $imagenSubida = $request->file("img")->move($destination, $fileName);
            $request->merge(['imagen' => $destination . $fileName]);
        }
        
        $presentacion_dep = PresentacionDep::create($request->all());
        return $this->successResponse($presentacion_dep);

    }

    public function update(Request $request, $presentacion_dep)
    {
        $rules = [
            'titulo' => 'max:120',
            'descripcion' => 'max:255',
            'deporte' => 'max:120',
            'lugar' => 'max:120',
            'imagen' => 'max:255',
            'fecha' => 'max:255',
        ];

        $this->validate($request, $rules);
        $presentacion_dep = PresentacionDep::findOrFail($presentacion_dep);
        $presentacion_dep = $presentacion_dep->fill($request->all());

        if ($presentacion_dep->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $presentacion_dep->save();
        return $this->successResponse($presentacion_dep);
    }


    public function destroy($presentacion_dep)
    {

        $presentacion_dep = PresentacionDep::findOrFail($presentacion_dep);
        $presentacion_dep->delete();
        return $this->successResponse($presentacion_dep);
    }


}