<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verifier.role:admin,directeur_publication');
    }

    /**
     * Display a listing of contacts.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        // Filtrage par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('objet', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(20);

        // Statistiques pour les badges
        $stats = [
            'total' => Contact::count(),
            'nouveaux' => Contact::nouveaux()->count(),
            'lus' => Contact::lus()->count(),
            'traites' => Contact::traites()->count(),
            'archives' => Contact::archives()->count(),
        ];

        return view('dashboard.contacts.index', compact('contacts', 'stats'));
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        // Marquer comme lu automatiquement lors de l'ouverture
        if ($contact->statut === 'nouveau') {
            $contact->marquerCommeLu();
        }

        return view('dashboard.contacts.show', compact('contact'));
    }

    /**
     * Update contact status or notes.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'statut' => 'sometimes|in:nouveau,lu,traite,archive',
            'notes_admin' => 'nullable|string'
        ]);

        $data = $request->only(['statut', 'notes_admin']);

        // Si on change le statut vers "lu" et qu'il n'a pas encore été lu
        if (isset($data['statut']) && $data['statut'] === 'lu' && $contact->statut === 'nouveau') {
            $data['date_lecture'] = now();
        }

        $contact->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Contact mis à jour avec succès'
        ]);
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('dashboard.contacts.index')
            ->with('success', 'Contact supprimé avec succès');
    }

    /**
     * Bulk actions for multiple contacts.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:marquer_lu,marquer_traite,archiver,supprimer',
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id'
        ]);

        $contacts = Contact::whereIn('id', $request->contact_ids);

        switch ($request->action) {
            case 'marquer_lu':
                $contacts->update([
                    'statut' => 'lu',
                    'date_lecture' => now()
                ]);
                $message = 'Contacts marqués comme lus';
                break;

            case 'marquer_traite':
                $contacts->update(['statut' => 'traite']);
                $message = 'Contacts marqués comme traités';
                break;

            case 'archiver':
                $contacts->update(['statut' => 'archive']);
                $message = 'Contacts archivés';
                break;

            case 'supprimer':
                $contacts->delete();
                $message = 'Contacts supprimés';
                break;

            default:
                return redirect()->back()->with('error', 'Action non reconnue');
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Export contacts to CSV.
     */
    public function export(Request $request)
    {
        $query = Contact::query();

        // Appliquer les mêmes filtres que pour l'index
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('objet', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')->get();

        $filename = 'contacts_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');
            
            // Headers CSV
            fputcsv($file, [
                'ID',
                'Nom',
                'Email',
                'Objet',
                'Message',
                'Statut',
                'Date de création',
                'Date de lecture',
                'Notes admin'
            ]);

            // Données
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->id,
                    $contact->nom,
                    $contact->email,
                    $contact->objet,
                    $contact->message,
                    $contact->status_label,
                    $contact->created_at->format('d/m/Y H:i'),
                    $contact->date_lecture ? $contact->date_lecture->format('d/m/Y H:i') : '',
                    $contact->notes_admin
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}