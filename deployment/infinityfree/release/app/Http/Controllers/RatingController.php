<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request, Content $content): JsonResponse|RedirectResponse
    {
        $profileId = session('active_profile_id');
        if ($profileId) {
            abort_unless($request->user()->profiles()->whereKey($profileId)->exists(), 403);
        }

        Rating::updateOrCreate(
            ['user_id' => $request->user()->id, 'content_id' => $content->id],
            [
                'rating' => $request->rating,
                'review' => $request->input('review'),
                'review_status' => filled($request->input('review')) ? 'pending' : null,
                'review_moderation_note' => null,
                'admin_reply' => null,
                'admin_reaction' => null,
                'profile_id' => $profileId,
            ]
        );

        if (! $request->expectsJson()) {
            $message = filled($request->input('review'))
                ? 'Your rating is saved. Your review has been sent to the admin for approval.'
                : 'Your rating has been saved.';

            return back()->with('rating_saved', $message);
        }

        return response()->json([
            'average' => $content->averageRating(),
            'count'   => $content->ratingsCount(),
            'user_rating' => $request->rating,
        ]);
    }
}
