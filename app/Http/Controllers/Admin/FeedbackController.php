<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function index(Request $request): View
    {
        $feedback = Feedback::with('user')
            ->when($request->type,   fn($q, $v) => $q->where('type', $v))
            ->when($request->status, fn($q, $v) => $q->where('status', $v))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.feedback.index', compact('feedback'));
    }

    public function show(Feedback $feedback): View
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback): \Illuminate\Http\JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'status'      => 'required|in:new,reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:2000',
        ]);
        $feedback->update($data);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true]);
        }

        return back()->with('success', 'Feedback updated.');
    }

    public function destroy(Feedback $feedback): RedirectResponse
    {
        $feedback->delete();
        return redirect()->route('admin.feedback.index')->with('success', 'Feedback deleted.');
    }
}
