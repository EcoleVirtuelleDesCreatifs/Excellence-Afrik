<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Models\Contact; // Importer le modèle Contact
use Illuminate\Support\Facades\Log; // Importer le logger

class PageController extends Controller
{
    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContactForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            // 1. Enregistrer dans la base de données
            Contact::create([
                'nom' => $validatedData['name'],
                'email' => $validatedData['email'],
                'objet' => $validatedData['subject'],
                'message' => $validatedData['message'],
                'statut' => 'nouveau', // Statut par défaut
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // 2. Envoyer l'e-mail
            Mail::to(config('mail.from.address'))->send(new ContactFormMail($validatedData));

            return redirect()->route('pages.contact')->with('success', 'Votre message a été envoyé et enregistré avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur du formulaire de contact: ' . $e->getMessage());
            return redirect()->route('pages.contact')->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }
}
