<?php

namespace App\Livewire;

use App\Models\Mail;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Mail\ManualMail;
use Livewire\Component;
use Illuminate\Support\Facades\Mail as SupportMail;

use Illuminate\Support\Facades\DB;

class MailEditComponent extends Component
{
    public $mail;
    
    public $sujet;
    public $corps;
    
    public $userids=[];
    public $recipients=[];

    protected $listeners = ['userListUpdated', '$refresh'];

    public function userListUpdated($userids)
    {
        $this->userids = $userids;
        $this->makeQuery();
        $this->emitSelf('$refresh');
    }
    
    public function mount($mail)
    {
        if ($mail == null)
        {
            $mail=Mail::create();
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
                ->bcc('ffast.notification.tec@intradef.gouv.fr')
                ->queue($newMail);
    }
    
    public function save()
    {
        $this->mail->sujet = $this->sujet;
        $this->mail->corps = $this->corps;
        $this->mail->save();
    }
}
