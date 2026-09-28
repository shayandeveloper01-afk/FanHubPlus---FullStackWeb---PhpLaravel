<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource as FanResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(): View
    {
        $resources = FanResource::with('user')->latest()->paginate(30);
        return view('admin.resources.index', compact('resources'));
    }

    public function moderate(Request $request, FanResource $resource): RedirectResponse
    {
        $data = $request->validate([
            'decision' => ['required', 'in:approve,reject'],
            'reason' => ['nullable', 'required_if:decision,reject', 'string', 'max:1000'],
        ]);
        $resource->update([
            'is_approved' => $data['decision'] === 'approve',
            'moderation_reason' => $data['decision'] === 'reject' ? $data['reason'] : null,
        ]);

        return back()->with('success', 'Resource moderation updated.');
    }
}
