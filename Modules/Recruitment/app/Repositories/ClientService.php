<?php

namespace Modules\Recruitment\Services;

use Modules\Recruitment\Repositories\ClientRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientService
{
    protected $repository;

    public function __construct(ClientRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all clients with optional filtering
     */
    public function getAllClients($filters = [])
    {
        // Start with a new query builder instead of fetching all records
        $query = $this->repository->newQuery();

        if (isset($filters['active'])) {
            $query->where('is_active', $filters['active']);
        }

        if (isset($filters['featured'])) {
            $query->where('is_featured', $filters['featured']);
        }

        if (isset($filters['subscription_tier'])) {
            $query->where('subscription_tier', $filters['subscription_tier']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('company_type', 'like', "%{$search}%")
                    ->orWhere('industry', 'like', "%{$search}%")
                    ->orWhere('primary_email', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    /**
     * Create a new client
     */
    public function createClient(array $data)
    {
        try {
            DB::beginTransaction();

            // Handle file uploads if present
            if (isset($data['client_logo'])) {
                $data['client_logo_path'] = $data['client_logo'];
                unset($data['client_logo']);
            }

            if (isset($data['banner_image'])) {
                $data['banner_image_path'] = $data['banner_image'];
                unset($data['banner_image']);
            }

            // Set default values for required fields
            $data['is_active'] = $data['is_active'] ?? true;
            $data['is_featured'] = $data['is_featured'] ?? false;
            $data['subscription_tier'] = $data['subscription_tier'] ?? 1;
            $data['jobs_posted_count'] = $data['jobs_posted_count'] ?? 0;
            $data['login_count'] = $data['login_count'] ?? 0;

            // Create the client
            $client = $this->repository->create($data);

            DB::commit();
            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating client: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update an existing client
     */
    public function updateClient(array $data, $id)
    {
        try {
            DB::beginTransaction();

            $client = $this->repository->find($id);

            if (!$client) {
                throw new \Exception('Client not found');
            }

            // Handle file uploads if present
            if (isset($data['client_logo'])) {
                $data['client_logo_path'] = $data['client_logo'];
                unset($data['client_logo']);
            }

            if (isset($data['banner_image'])) {
                $data['banner_image_path'] = $data['banner_image'];
                unset($data['banner_image']);
            }

            // Update the client
            $client = $this->repository->update($data, $id);

            DB::commit();
            return $client;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating client: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a client
     */
    public function deleteClient($id)
    {
        try {
            DB::beginTransaction();

            $client = $this->repository->find($id);

            if (!$client) {
                throw new \Exception('Client not found');
            }

            // Delete the client
            $result = $this->repository->delete($id);

            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting client: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get client by ID
     */
    public function getClientById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update client subscription
     */
    public function updateSubscription($id, $tier, $expiry = null)
    {
        $data = [
            'subscription_tier' => $tier
        ];

        if ($expiry) {
            $data['subscription_expiry'] = $expiry;
        }

        return $this->updateClient($data, $id);
    }

    /**
     * Toggle client active status
     */
    public function toggleActiveStatus($id)
    {
        $client = $this->repository->find($id);

        if (!$client) {
            throw new \Exception('Client not found');
        }

        return $this->updateClient(['is_active' => !$client->is_active], $id);
    }

    /**
     * Toggle client featured status
     */
    public function toggleFeaturedStatus($id)
    {
        $client = $this->repository->find($id);

        if (!$client) {
            throw new \Exception('Client not found');
        }

        return $this->updateClient(['is_featured' => !$client->is_featured], $id);
    }

    /**
     * Increment jobs posted count
     */
    public function incrementJobsPostedCount($id)
    {
        $client = $this->repository->find($id);

        if (!$client) {
            throw new \Exception('Client not found');
        }

        return $this->updateClient(['jobs_posted_count' => $client->jobs_posted_count + 1], $id);
    }

    /**
     * Update client login information
     */
    public function updateLoginInfo($id)
    {
        $client = $this->repository->find($id);

        if (!$client) {
            throw new \Exception('Client not found');
        }

        return $this->updateClient([
            'last_login_at' => now(),
            'login_count' => $client->login_count + 1
        ], $id);
    }
}
