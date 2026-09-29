<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $status = request()->query('status', 'pending');
        abort_unless(in_array($status, ['pending', 'approved', 'rejected', 'all'], true), 404);

        $reviews = Rating::query()
            ->with(['user:id,name,email', 'content:id,title'])
            ->when($status !== 'all', fn ($query) => $query->where('review_status', $status))
            ->whereNotNull('review')
            ->where('review', '<>', '')
            ->latest()
            ->paginate(25);

        return view('admin.reviews.index', compact('reviews', 'status'));
    }

    public function moderate(Request $request, Rating $rating): RedirectResponse
    {
        abort_unless(filled($rating->review), 404);

        $data = $request->validate([
            'decision' => ['required', 'in:approve,reject,keep'],
            'admin_reply' => ['nullable', 'string', 'max:2000'],
            'admin_reaction' => ['nullable', 'in:like,heart,thanks'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $rating->update([
            'review_status' => match ($data['decision']) {
                'approve' => 'approved',
                'reject' => 'rejected',
                default => $rating->review_status,
            },
            'review_moderation_note' => $data['decision'] === 'reject' ? ($data['reason'] ?? null) : null,
            'admin_reply' => $data['admin_reply'] ?? null,
            'admin_reaction' => $data['admin_reaction'] ?? null,
        ]);

        $message = match ($data['decision']) {
            'approve' => 'Review approved and published with the admin response.',
            'reject' => 'Review rejected and kept private.',
            default => 'Admin reply and reaction saved.',
        };

        return back()->with('success', $message);
    }
}
