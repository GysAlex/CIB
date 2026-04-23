<?php

namespace App\Livewire;

use App\Mail\ContactRequestMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $projectType;
    public $message;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'phone' => 'required',
        'projectType' => 'required',
        'message' => 'required|min:10',
    ];

    protected $messages = [
        'name.required' => 'Le nom est obligatoire.',
        'email.required' => 'L\'adresse email est requise.',
        'email.email' => 'Format d\'email invalide.',
        'phone.required' => 'Le numéro de téléphone est nécessaire pour vous recontacter.',
        'projectType.required' => 'Veuillez sélectionner un type de projet.',
        'message.required' => 'Dites-nous en un peu plus sur votre projet.',
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        try {
            Mail::to('votre-email@domaine.com')->send(new ContactRequestMail($validatedData));

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
