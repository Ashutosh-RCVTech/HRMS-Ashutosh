<?php

namespace Modules\Recruitment\Repositories;

use Illuminate\Database\Eloquent\Model;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get sortable columns for this repository
     * 
     * @return array
     */
    public function getSortableColumns(): array;

    /**
     * Get searchable columns for this repository
     * 
     * @return array
     */
    public function getSearchableColumns(): array;

    /**
     * Get read status filter
     * 
     * @param string|null $status
     * @return array
     */
    public function getReadStatusFilter(?string $status): array;

    /**
     * Mark contact as read/unread
     * 
     * @param int $id
     * @param bool $isRead
     * @return Model
     */
    public function toggleReadStatus(int $id, bool $isRead): Model;

    /**
     * Bulk delete contacts
     * 
     * @param array $ids
     * @return int
     */
    public function bulkDelete(array $ids): int;

    /**
     * Save reply for a contact
     * 
     * @param int $id
     * @param string $replyMessage
     * @param int $userId
     * @return Model
     */
    public function saveReply(int $id, string $replyMessage, int $userId): Model;
}
