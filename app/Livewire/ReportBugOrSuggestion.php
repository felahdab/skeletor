<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;

use App\Events\BugOrSuggestionReportEvent;

class ReportBugOrSuggestion extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public string $url;

    public function mount(string $url): void
    {
        $this->url = $url;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('commentaire')
                    ->label('Commentaire ou bug')
                    ->cols(40)
                    ->rows(10)
                    ->required()
                    ->maxLength(1000),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $event=[];
        $event["user"] = auth()->user();
        $event["url"] = $this->url;
        $event["commentaire"] = $data['commentaire'];

        event(new BugOrSuggestionReportEvent(user: $event["user"], url: $event["url"], commentaire: $event["commentaire"]));

        Notification::make()
            ->title('Merci pour votre retour !')
            ->body('Votre commentaire a bien été envoyé.')
            ->success()
            ->send();

        $this->dispatch('close-modal', id: 'report-bug-or-suggestion');

    }

    public function render(): View
    {
        return view('livewire.report-bug-or-suggestion');
    }
}