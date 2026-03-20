<?php

namespace App\Livewire;

use App\Mail\ManualMail;
use App\Models\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Mail as SupportMail;
use Livewire\Component;

class MailEditComponent extends Component
{
    public $mail;

    public $sujet;
    public $corps;

    public $userids = [];
    public $recipients = [];

    protected $listeners = ['userListUpdated', '$refresh'];

    public function userListUpdated($userids)
    {
        $this->userids = $userids;
        $this->makeQuery();
        $this->dispatch('$refresh');
    }

    public function mount($mail)
    {
        if (null == $mail) {
            $mail = Mail::create();
        }
        $this->mail = $mail;
        $this->sujet = $this->mail->sujet;
        $this->corps = $this->mail->corps;
    }

    public function makeQuery()
    {
        $this->recipients = User::whereIn('id', $this->userids)->get() ?: [];
    }

    public function render()
    {
        $this->makeQuery();

        return view('livewire.mail-edit-component');
    }

    public function sendToUsers()
    {
        $this->makeQuery();
        $newMail = new ManualMail($this->corps, $this->sujet);
        SupportMail::to($this->recipients)
            ->bcc(config('skeletor.destinataire_systematique_bcc'))
            ->queue($newMail)
        ;
    }

    public function save()
    {
        $this->mail->sujet = $this->sujet;
        $this->mail->corps = $this->corps;
        $this->mail->save();
    }
}
