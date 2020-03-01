<?php

namespace App\Http\Controllers;

use App\Filters\Set\BikeFilterSet;
use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var BikeFilterSet
     */
    private $filterSet;

    public function __construct(Request $request, BikeFilterSet $filterSet)
    {
        $this->request = $request;
        $this->filterSet = $filterSet;
    }

    public function index()
    {
        return $this->filterSet
            ->setRequest($this->request)
            ->getBuilder()
            ->latest()
            ->paginate(20);
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
