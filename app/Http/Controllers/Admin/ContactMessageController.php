<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::with('service');

        if ($request->filled('status') && in_array($request->status, ['new', 'read', 'replied'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest()->paginate(15)->withQueryString();
        $statusCounts = [
            'new' => ContactMessage::new()->count(),
            'read' => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
        ];

        return view('admin.messages.index', compact('messages', 'statusCounts'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === ContactMessage::STATUS_NEW) {
            $message->update(['status' => ContactMessage::STATUS_READ]);
        }

        return view('admin.messages.show', compact('message'));
    }

    public function markReplied(ContactMessage $message)
    {
        $message->update(['status' => ContactMessage::STATUS_REPLIED]);

        return back()->with('success', 'Message marked as replied.');
    }

    public function markRead(ContactMessage $message)
    {
        $message->update(['status' => ContactMessage::STATUS_READ]);

        return back()->with('success', 'Message marked as read.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
