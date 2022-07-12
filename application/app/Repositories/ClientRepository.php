<?php

namespace App\Repositories;

use App\Models\Client;

class ClientRepository
{
    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function delete(int $id): bool
    {
        $client = $this->findById($id);
        
        if ($client === null) {
            return false;
        }

        $client->delete();

        return true;
    }

    public function findById(int $id): ?Client
    {
        return Client::find($id);
    }

    public function update(int $id, array $data): ?Client
    {
        $client = $this->findById($id);

        if ($client === null) {
            return null;
        }

        $client->update($data);

        return $client;
    }

    public function getAll()
    {
        return Client::all();
    }
}
