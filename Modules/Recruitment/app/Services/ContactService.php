<?php

namespace Modules\Recruitment\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Modules\Recruitment\Mail\ContactReply;
use Illuminate\Support\Facades\Log;
use Modules\Recruitment\Models\Contact;
use Modules\Recruitment\Repositories\ContactRepositoryInterface;

class ContactService
{
    protected $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Get paginated contacts with search and filters
     * 
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getPaginatedContacts(array $params): LengthAwarePaginator
    {
        // Handle read status filter
        $filters = $this->contactRepository->getReadStatusFilter($params['status'] ?? null);

        // Get sortable and searchable columns
        $sortableColumns = $this->contactRepository->getSortableColumns();
        $searchableColumns = $this->contactRepository->getSearchableColumns();

        // Set sorting parameters
        $sortColumn = in_array($params['sort_column'] ?? '', $sortableColumns)
            ? $params['sort_column']
            : 'created_at';

        $sortDirection = in_array(strtolower($params['sort_order'] ?? ''), ['asc', 'desc'])
            ? strtolower($params['sort_order'])
            : 'desc';

        // Get search query
        $searchQuery = $params['search'] ?? '';

        // Get per page
        $perPage = (int)($params['per_page'] ?? 10);

        // Return filtered and paginated results
        return $this->contactRepository->filteredPaginate(
            $filters,
            $searchQuery,
            $searchableColumns,
            $sortColumn,
            $sortDirection,
            $sortableColumns,
            $perPage
        );
    }

    /**
     * Get a specific contact
     * 
     * @param int $id
     * @return Contact
     */
    public function getContact(int $id): Contact
    {
        return $this->contactRepository->find($id);
    }

    /**
     * Mark contact as read
     * 
     * @param int $id
     * @return Contact
     */
    public function markAsRead(int $id): Contact
    {
        return $this->contactRepository->toggleReadStatus($id, true);
    }

    /**
     * Toggle read status
     * 
     * @param int $id
     * @param bool $currentStatus
     * @return Contact
     */
    public function toggleReadStatus(int $id, bool $currentStatus): Contact
    {
        return $this->contactRepository->toggleReadStatus($id, !$currentStatus);
    }

    /**
     * Delete contact
     * 
     * @param int $id
     * @return bool
     */
    public function deleteContact(int $id): bool
    {
        return $this->contactRepository->delete($id);
    }

    /**
     * Bulk delete contacts
     * 
     * @param array $ids
     * @return int
     */
    public function bulkDeleteContacts(array $ids): int
    {
        return $this->contactRepository->bulkDelete($ids);
    }

    /**
     * Reply to contact
     * 
     * @param int $id
     * @param string $replyMessage
     * @param int $userId
     * @return bool
     */
    public function replyToContact(int $id, string $replyMessage, int $userId): bool
    {
        $contact = $this->contactRepository->saveReply($id, $replyMessage, $userId);

        try {
            Mail::to($contact->email)->send(new ContactReply($contact));
            return true;
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to send contact reply email: ' . $e->getMessage());
            return false;
        }
    }
}
