<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'question'     => 'required|string|max:500',
            'answer'       => 'required|string',
            'keywords'     => 'nullable|string|max:500',
            'sort_order'   => 'integer|min:0',
            'is_published' => 'boolean',
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $data['keywords'] = Faq::normalizeKeywords($data['keywords'] ?? []);
        Faq::create($data);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $data = $request->validate([
            'question'     => 'required|string|max:500',
            'answer'       => 'required|string',
            'keywords'     => 'nullable|string|max:500',
            'sort_order'   => 'integer|min:0',
            'is_published' => 'boolean',
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $data['keywords'] = Faq::normalizeKeywords($data['keywords'] ?? []);
        $faq->update($data);
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }
}
