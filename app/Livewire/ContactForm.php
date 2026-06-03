<?php

namespace App\Livewire;

use App\Mail\ContactRequestMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContactForm extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $phone;
    public $projectType;
    public $message;

    public $attachments = [];

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'phone' => 'required',
        'projectType' => 'required',
        'message' => 'required|min:10',
        'attachments.*' => 'nullable|file|mimes:pdf,docx,jpeg,png,jpg|max:10240',
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L\'adresse email est requise.',
        'email.email' => 'Format d\'email invalide.',
        'phone.required' => 'Le numéro de téléphone est nécessaire pour vous recontacter.',
        'projectType.required' => 'Veuillez sélectionner un type de projet.',
        'message.required' => 'Dites-nous en un peu plus sur votre projet.',
        'attachments.*.mimes' => 'Les formats acceptés sont : PDF, DOCX, JPG et PNG.',
        'attachments.*.max' => 'Chaque fichier ne doit pas dépasser 10 Mo.',
    ];

    public function submit()
    {
        $validatedData = $this->validate();
        $storedFiles = [];

        // Traitement et stockage des pièces jointes
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $file) {
                $storedFiles[] = $file->store('attachments');
            }
        }

        try {
            Mail::to('leseulguide@cib-construction.com')->send(new ContactRequestMail($validatedData, $storedFiles));

            session()->flash('message', 'Votre demande a été envoyée avec succès ! Notre équipe vous recontactera sous 24h.');
            $this->reset();

        } catch (\Exception $e) {
            session()->flash('error', 'Désolé, une erreur est survenue lors de l\'envoi. Veuillez réessayer plus tard.');
        }

        session()->flash('message', 'Votre demande a été envoyée avec succès ! Notre équipe vous recontactera sous 24h.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
