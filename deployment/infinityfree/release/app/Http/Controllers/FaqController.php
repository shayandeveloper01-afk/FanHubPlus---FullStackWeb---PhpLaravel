<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        return view('faqs.index', ['faqs' => Faq::published()->get()]);
    }

    public function search(Request $request): JsonResponse
    {
        $query = strtolower(trim((string) $request->input('q', '')));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $faqs = Faq::published()->get();

        $results = $faqs->filter(function (Faq $faq) use ($query) {
            foreach ($faq->keywordList() as $kw) {
                $kw = strtolower($kw);
                if ($kw !== '' && str_contains($query, $kw)) return true;
            }
            return str_contains(strtolower($faq->question), $query)
                || str_contains(strtolower($faq->answer), $query);
        })->values()->take(3)->map(fn($f) => [
            'question' => $f->question,
            'answer'   => $f->answer,
        ]);

        return response()->json($results);
    }
}
