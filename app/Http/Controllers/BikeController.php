<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store()
    {
        $this->validate($this->request, [
            'licence_number' => ['required', 'digits:10', 'unique:bikes,licence_number'],
            'owner' => ['required', 'max:50'],
            'color' => ['required', 'max:20'],
            'type' => ['required', 'max:20'],
            'theft_at' => ['required', 'date'],
            'description' => ['required', 'max:300'],
        ]);

        $bike = Bike::create($this->request->all());

        return response()->json($bike, 201);
    }
}
