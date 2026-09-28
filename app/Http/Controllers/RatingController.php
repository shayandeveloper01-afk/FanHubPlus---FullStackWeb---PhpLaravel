<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Rating;
use App\Http\Requests\StoreRatingRequest;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    public function store(StoreRatingRequest $request, Content $content): JsonResponse
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
                'profile_id' => $profileId,
            ]
        );

        return response()->json([
            'average' => $content->averageRating(),
            'count'   => $content->ratingsCount(),
            'user_rating' => $request->rating,
        ]);
    }
}
