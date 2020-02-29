<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $officer = Officer::create($request->all());

        return response()->json(['id' => $officer->id, 'name' => $officer->name], 201);
    }

    public function destroy($id)
    {
        Officer::findOrFail($id)->delete();

        return response()->json([], 204);
    }
}
