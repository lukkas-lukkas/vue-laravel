<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientController extends Controller
{
    public function __construct(
        private Request $request,
        private ClientRepository $repository
    ) {        
    }

    // METHOD: GET
    public function index()
    {
        $data = $this->repository->getAll();

        return response()->json($data->toArray(), 200);
    }

    // METHOD: POST
    public function store()
    {
        $data = $this->request->all();

        $client = $this->repository->create($data);

        return response()->json($client, 201);
    }

    // METHOD: GET
    public function show(int $id)
    {
        $client = $this->repository->findById($id);

        if ($client === null) {
            return response()->json(['Client not found'], 404);
        }

        return response()->json($client, 200);
    }

    // METHOD: PUT | PATCH
    public function update(int $id)
    {
        $data = $this->request->except('id');

        $client = $this->repository->update($id, $data);

        if ($client === null) {
            return response()->json(['Client not found'], 404);
        }

        return response()->json($client, 200);
    }

    // METHOD: DELETE
    public function destroy(int $id)
    {
        $result = $this->repository->delete($id);

        if ($result === false) {
            return response()->json(['Client not found'], 404);
        }

        return response()->json(['success'], 200);
    }
}
