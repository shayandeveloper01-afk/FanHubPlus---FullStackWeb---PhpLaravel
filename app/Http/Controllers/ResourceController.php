<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Models\Resource as FanResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(): View
    {
        $resources = FanResource::with(['user', 'content'])->where('is_approved', true)->latest()->paginate(24);
        return view('resources.index', compact('resources'));
    }

    public function store(StoreResourceRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $request->user()->resources()->create([
            ...$request->safe()->except('file'),
            'file_path' => $file->store('fan-resources', 'local'),
            'file_size_kb' => (int) ceil($file->getSize() / 1024),
        ]);

        return back()->with('success', 'Resource submitted for moderator review.');
    }

    public function download(FanResource $resource): Response
    {
        abort_unless($resource->is_approved && Storage::disk('local')->exists($resource->file_path), 404);
        $resource->increment('download_count');
        return Storage::disk('local')->download($resource->file_path, basename($resource->file_path));
    }
}
