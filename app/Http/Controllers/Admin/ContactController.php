<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(Request $request): Response
    {
        $contacts = ContactForm::query()
            ->when($request->status === 'unread', fn($q) => $q->unread())
            ->when($request->status === 'unreplied', fn($q) => $q->unreplied())
            ->when($request->search, fn($q, $s) => $q->where(fn($q) =>
                $q->where('full_name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
            ))
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Contacts/Index', compact('contacts'));
    }

    public function show(ContactForm $contact): Response
    {
        $contact->markAsRead();

        return Inertia::render('Admin/Contacts/Show', compact('contact'));
    }

    public function markReplied(ContactForm $contact): RedirectResponse
    {
        $contact->markAsReplied();
        return back()->with('success', 'Marqué comme répondu.');
    }

    public function addNote(Request $request, ContactForm $contact): RedirectResponse
    {
        $request->validate(['notes' => 'required|string|max:1000']);
        $contact->update(['admin_notes' => $request->notes]);
        return back()->with('success', 'Note enregistrée.');
    }

    public function destroy(ContactForm $contact): RedirectResponse
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé.');
    }
}