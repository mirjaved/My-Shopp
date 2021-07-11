<?php

namespace App\Http\Livewire;

use App\Models\Setting;
use App\Models\Contact;
use Livewire\Component;

class ContactComponent extends Component
{
    public $name;
    public $email;
    public $phone;
    public $comment;

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'comment' => 'required'
        ]);
    }

    public function resetInputFields()
    {        
        $this->name = '';
        $this->title = '';
        $this->email = '';
        $this->phone = '';
        $this->comment = '';        
    }

    public function sendMessage()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'comment' => 'required'
        ]);

        $contact = new Contact();
        $contact->name = $this->name;
        $contact->email = $this->email;
        $contact->phone = $this->phone;
        $contact->comment = $this->comment;
        $contact->save();
        session()->flash('message', 'Thank you! The message is sent successfully.');
        $this->resetInputFields();
    }

    public function render()
    {
        $setting = Setting::find(1);
        return view('livewire.contact-component', ['setting' => $setting])->layout('layouts.index');
    }
}
