<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatFaq;
use Illuminate\Http\Request;

class ChatFaqController extends Controller
{
    public function index(Request $request)
    {
        $query = ChatFaq::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('question', 'like', '%' . $request->search . '%')
                  ->orWhere('answer', 'like', '%' . $request->search . '%');
            });
        }

        $faqs = $query->orderBy('priority', 'desc')->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.chat-faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.chat-faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:5000',
            'category' => 'nullable|string|max:100',
            'roles' => 'nullable|array',
            'roles.*' => 'string',
            'keywords' => 'nullable|string',
            'deep_links' => 'nullable|string',
            'priority' => 'integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        // Parse keywords dari comma-separated string
        $validated['keywords'] = $request->filled('keywords')
            ? array_map('trim', explode(',', $request->keywords))
            : null;

        // Parse deep_links dari JSON string
        $validated['deep_links'] = $request->filled('deep_links')
            ? json_decode($request->deep_links, true)
            : null;

        $validated['is_active'] = $request->boolean('is_active', true);

        ChatFaq::create($validated);

        return redirect()->route('admin.chat-faqs.index')->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function edit(ChatFaq $faq)
    {
        return view('admin.chat-faqs.edit', compact('faq'));
    }

    public function update(Request $request, ChatFaq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:5000',
            'category' => 'nullable|string|max:100',
            'roles' => 'nullable|array',
            'roles.*' => 'string',
            'keywords' => 'nullable|string',
            'deep_links' => 'nullable|string',
            'priority' => 'integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['keywords'] = $request->filled('keywords')
            ? array_map('trim', explode(',', $request->keywords))
            : null;

        $validated['deep_links'] = $request->filled('deep_links')
            ? json_decode($request->deep_links, true)
            : null;

        $validated['is_active'] = $request->boolean('is_active', true);

        $faq->update($validated);

        return redirect()->route('admin.chat-faqs.index')->with('success', 'FAQ berhasil diupdate!');
    }

    public function destroy(ChatFaq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.chat-faqs.index')->with('success', 'FAQ berhasil dihapus!');
    }
}
