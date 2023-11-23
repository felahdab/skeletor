<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Mail;
use Illuminate\Contracts\View\View;

class MailTable extends DataTableComponent
{
    protected $model = Mail::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-hover',
        ]);
    }

    public function userActions(): View
    {
        return view('tables.mailstable.gestion');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            Column::make("Destinataires", "destinataires")
                ->sortable(),
            Column::make("Sujet", "sujet")
                ->sortable(),
            Column::make("Corps", "corps")
                ->sortable(),
            Column::make("Date d'envoie", "date_envoi")
                ->sortable(),
            Column::make('Actions')
                ->label(
                    fn($row, Column $column) => $this->userActions()->with("row", $row)
                    ),
        ];
    }

    public function deleteMail($rowid)
    {
        $mail = Mail::find($rowid);
        $mail->delete();
    }
}
