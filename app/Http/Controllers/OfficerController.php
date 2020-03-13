<?php

namespace App\Http\Controllers;

use App\Models\Officer;
use App\Repositories\OfficerRepository;
use Illuminate\Http\Request;

class OfficerController extends Controller
{

    /**
     * @var OfficerRepository
     */
    private $repository;

    public function __construct(OfficerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $officer = $this->repository->create($request->all());


        if ($officer) {
            return response()->json($officer, 201);
        }

        return response()->json([], 500);
    }

    public function destroy($id)
    {
        Officer::findOrFail($id)->delete();

        return response()->json([], 204);
    }
}
