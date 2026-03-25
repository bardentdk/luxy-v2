<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function __construct(private readonly ContactService $contactService)
    {}

    public function index(): Response
    {
        return Inertia::render('Public/Contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $this->contactService->store($request->validated());

        return back()->with('success', 'Votre message a bien été envoyé ! Nous vous répondrons dans les plus brefs délais.');
    }
}