<?php

namespace App\Http\Livewire;

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
    
    public $query="";
    public $recipients=[];
    
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
        if ($this->query=="")
            $this->recipients=[];
        else
            $this->recipients= User::where('display_name', 'LIKE', '%' . $this->query . '%')->get();
    }
    
    public function render()
    {
        $this->makeQuery();
        return view('livewire.mail-edit-component');
    }
    
    public function sendToUsers()
    {
        $newMail = new ManualMail($this->corps, $this->sujet);
        SupportMail::to($this->recipients)
                ->bcc('florian.el-ahdab@intradef.gouv.fr')
                ->queue($newMail);
    }
    
    public function sendToAllPriviledgedUsers()
    {
        $roles = Role::whereNotIn('name', ['user', 'transfo'])->get();
        $recipients = User::role($roles)->get();
        $newMail = new ManualMail($this->corps, $this->sujet);
        SupportMail::to($recipients)
            ->bcc('florian.el-ahdab@intradef.gouv.fr')
            ->queue($newMail);
    }
    
    public function save()
    {
        $this->mail->sujet = $this->sujet;
        $this->mail->corps = $this->corps;
        $this->mail->save();
    }
}
