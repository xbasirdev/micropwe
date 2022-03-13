<?php

namespace App\Http\Controllers;

use App\Verification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{

    public function index()
    {
        $verification = Verification::all();
        return $this->successResponse($verification);
    }

    public function show($verification)
    {
        $verification = Verification::findOrFail($verification);
        return $this->successResponse($verification);
    }

    public function store(Request $request)
    {
        $rules = [
            'codigo' => 'required|max:120',
        ];

        $this->validate($request, $rules);
        $verification = Verification::create($request->all());
        return $this->successResponse($verification);

    }

    public function update(Request $request, $verification)
    {
        $rules = [
            'codigo' => 'max:120',
        ];

        $this->validate($request, $rules);
        $verification = Verification::findOrFail($verification);
        $verification = $verification->fill($request->all());

        if ($verification->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $verification->save();
        return $this->successResponse($verification);
    }


    public function destroy($verification)
    {

        $verification = Verification::findOrFail($verification);
        $verification->delete();
        return $this->successResponse($verification);
    }


}