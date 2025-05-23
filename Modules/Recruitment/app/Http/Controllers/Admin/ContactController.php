<?php

namespace Modules\Recruitment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Recruitment\Services\ContactService;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the contact messages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contacts = $this->contactService->getPaginatedContacts($request->all());
        return view('recruitment::admin.contacts.index', compact('contacts'));
    }

    /**
     * Display the specified contact message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = $this->contactService->getContact($id);

        // Mark as read if not already
        if (!$contact->is_read) {
            $this->contactService->markAsRead($id);
        }

        return view('recruitment::admin.contacts.show', compact('contact'));
    }

    /**
     * Mark a contact message as read/unread.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleReadStatus(Request $request, $id)
    {
        $contact = $this->contactService->getContact($id);
        $updatedContact = $this->contactService->toggleReadStatus($id, $contact->is_read);

        return response()->json([
            'success' => true,
            'is_read' => $updatedContact->is_read,
            'message' => $updatedContact->is_read ? 'Marked as read' : 'Marked as unread'
        ]);
    }

    /**
     * Remove the specified contact message from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contactService->deleteContact($id);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully');
    }

    /**
     * Remove multiple contact messages from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer'
        ]);

        $count = $this->contactService->bulkDeleteContacts($request->ids);

        return response()->json([
            'success' => true,
            'message' => $count . ' messages deleted successfully'
        ]);
    }

    /**
     * Reply to a contact message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply_message' => 'required|string',
        ]);

        $success = $this->contactService->replyToContact(
            $id,
            $request->reply_message,
            auth()->id()
        );

        if ($success) {
            return redirect()->route('admin.contacts.show', $id)
                ->with('success', 'Reply sent successfully');
        } else {
            return redirect()->route('admin.contacts.show', $id)
                ->with('error', 'Failed to send email. The reply was saved but could not be delivered.');
        }
    }
}
