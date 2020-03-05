<?php

namespace App\Http\Controllers;

use App\Filters\Set\BikeFilterSet;
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
    /**
     * @var BikeFilterSet
     */
    private $filterSet;

    public function __construct(Request $request, BikeFilterSet $filterSet, BikeRepository $repository)
    {
        $this->request = $request;
        $this->filterSet = $filterSet;
        $this->repository = $repository;
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

        $bike = $this->repository->theft($this->request->all());
        if ($bike) {
            return response()->json($bike, 201);
        } else {
            return response()->json(['message' => 'Cannot store your report'], 500);
        }
    }
}
