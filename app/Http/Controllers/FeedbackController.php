<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function create(): View
    {
        return view('feedback.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => [Rule::requiredIf(! auth()->check()), 'nullable', 'string', 'max:100'],
            'email'   => [Rule::requiredIf(! auth()->check()), 'nullable', 'email', 'max:255'],
            'type'    => 'required|in:bug,suggestion,report,general',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $data['user_id'] = auth()->id();

        // Fill name/email from auth user if logged in
        if (auth()->check()) {
            $data['name']  = $data['name']  ?? auth()->user()->name;
            $data['email'] = $data['email'] ?? auth()->user()->email;
        }

        $feedback = Feedback::create($data);

        return back()
            ->with('success', 'Thank you! Your message has been submitted.')
            ->with('feedback_reference', $feedback->reference_code);
    }

    public function status(Request $request): View
    {
        $feedback = null;
        $searched = false;

        if ($request->isMethod('post')) {
            $request->validate([
                'query' => ['required', 'alpha_num', 'size:8'],
            ]);

            $query = trim($request->input('query'));
            $searched = true;

            // The reference code is an unguessable credential; email alone is not.
            $feedback = Feedback::where('reference_code', strtoupper($query))->get();
        }

        return view('feedback.status', compact('feedback', 'searched'));
    }
}
