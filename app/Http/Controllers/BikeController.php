<?php

namespace App\Http\Controllers;

use App\Repositories\BikeRepository;
use Illuminate\Http\Request;

class BikeController extends Controller
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var BikeRepository
     */
    private $repository;

    public function __construct(Request $request, BikeRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->filter($this->request);
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

        $bike = $this->repository->theft($this->request->all());
        if ($bike) {
            return response()->json($bike, 201);
        } else {
            return response()->json(['message' => 'Cannot store your report'], 500);
        }
    }

    public function resolve($id)
    {
        if ($this->repository->resolve($id)) {
            return response()->json([], 204);
        }

        return response()->json([], 204);
    }
}
