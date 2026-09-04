<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminApiController extends Controller
{
    public function stats(): JsonResponse
    {
        return response()->json([
            'services' => Service::count(),
            'projects' => Project::count(),
            'clients' => Client::count(),
            'testimonials' => Testimonial::count(),
            'users' => User::count(),
            'messages' => [
                'total' => ContactMessage::count(),
                'new' => ContactMessage::new()->count(),
                'read' => ContactMessage::where('status', 'read')->count(),
                'replied' => ContactMessage::where('status', 'replied')->count(),
            ],
        ]);
    }

    public function messages(Request $request): JsonResponse
    {
        $query = ContactMessage::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate((int) $request->integer('per_page', 20));

        return response()->json($messages);
    }

    public function showMessage(ContactMessage $message): JsonResponse
    {
        if ($message->status === ContactMessage::STATUS_NEW) {
            $message->update(['status' => ContactMessage::STATUS_READ]);
        }

        return response()->json($message->fresh());
    }

    public function markMessage(Request $request, ContactMessage $message): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:new,read,replied'],
        ]);

        $message->update($data);

        return response()->json($message->fresh());
    }

    public function destroyMessage(ContactMessage $message): JsonResponse
    {
        $message->delete();

        return response()->json(['ok' => true]);
    }

    public function messagesChart(): JsonResponse
    {
        $chartData = DB::table('contact_messages')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $labels = [];
        $values = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->format('M Y');
            $values[] = (int) ($chartData[$month] ?? 0);
        }

        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}
