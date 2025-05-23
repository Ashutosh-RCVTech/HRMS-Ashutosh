<?php

namespace Modules\Recruitment\Repositories;

use Modules\Recruitment\Models\Contact;
use Illuminate\Database\Eloquent\Model;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    /**
     * Get sortable columns for this repository
     * 
     * @return array
     */
    public function getSortableColumns(): array
    {
        return ['name', 'email', 'subject', 'created_at', 'is_read', 'replied_at'];
    }

    /**
     * Get searchable columns for this repository
     * 
     * @return array
     */
    public function getSearchableColumns(): array
    {
        return ['name', 'email', 'subject', 'message'];
    }

    /**
     * Get read status filter
     * 
     * @param string|null $status
     * @return array
     */
    public function getReadStatusFilter(?string $status): array
    {
        if ($status && in_array($status, ['read', 'unread'])) {
            return ['is_read' => $status === 'read'];
        }

        return [];
    }

    /**
     * Mark contact as read/unread
     * 
     * @param int $id
     * @param bool $isRead
     * @return Model
     */
    public function toggleReadStatus(int $id, bool $isRead): Model
    {
        return $this->update(['is_read' => $isRead], $id);
    }

    /**
     * Bulk delete contacts
     * 
     * @param array $ids
     * @return int
     */
    public function bulkDelete(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * Save reply for a contact
     * 
     * @param int $id
     * @param string $replyMessage
     * @param int $userId
     * @return Model
     */
    public function saveReply(int $id, string $replyMessage, int $userId): Model
    {
        return $this->update([
            'replied_at' => now(),
            'reply_message' => $replyMessage,
            'replied_by_user_id' => $userId,
            'is_read' => true,
        ], $id);
    }
}
