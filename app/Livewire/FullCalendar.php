<?php

namespace App\Livewire;

use Livewire\Component;

class FullCalendar extends Component
{
    public function eventClick($event)
    {
        ddd($event);
    }

    public function eventDrop($event)
    {
        ddd($event);
    }

    public function eventResize($event)
    {
        ddd($event);
    }

    public function getEvents()
    {
        return [
            [
                'id' => '1',
                'resourceIds' => ['a', 'b'],
                'title' => 'Formidable Shield 2023',
                'start' => '2023-09-28',
            ],
        ];
    }

    public function getResources()
    {
        return [
            [
                'id' => 'a',
                'groupId' => 'FDA',
                'title' => 'Chevalier Paul',
            ],
            [
                'id' => 'b',
                'groupId' => 'FDA',
                'title' => 'Forbin',
            ],
            [
                'id' => 'c',
                'groupId' => 'FLF',
                'title' => 'Courbet',
            ],
        ];
    }

    public function refreshCalendar()
    {
        $this->dispatch('refreshCalendar');
    }

    public function render()
    {
        return view('livewire.full-calendar');
    }
}
