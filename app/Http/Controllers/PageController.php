<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // La logique d'envoi d'e-mail sera ajoutée ici plus tard.
        // Pour l'instant, nous simulons le succès.

        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }

    /**
     * Show the editorial page.
     *
     * @return \Illuminate\View\View
     */
    public function editorial()
    {
        return view('pages.editorial');
    }

    /**
     * Show the legal notice page.
     *
     * @return \Illuminate\View\View
     */
    public function legal()
    {
        return view('pages.mentions-legales');
    }
}
