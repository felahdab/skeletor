<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Mail;

class MailTable extends DataTableComponent
{
    protected $model = Mail::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableRowUrl(function($row) {
            return route('mails.edit', $row);
        });
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
        ];
    }
}
