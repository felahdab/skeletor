<?php

namespace App\Http\Livewire;

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

    public function getEvents()
    {
        $events = [
            [
                'id' => '1',
                'resourceIds' => ['a', 'b'],
                'title' => 'Formidable Shield 2023',
                'start' => '2023-09-28'
            ]
        ];
        return $events;
    }

    public function getResources()
    {
        $resources = [
            [
                'id' => 'a',
                'groupId' => 'FDA',
                'title' => 'Chevalier Paul'
            ],
            [
                'id' => 'b',
                'groupId' => 'FDA',
                'title' => 'Forbin'
            ],
            [
                'id' => 'c',
                'groupId' => 'FLF',
                'title' => 'Courbet'
            ]
        ];
        return $resources;
    }

    public function refreshCalendar(){
        $this->emit('refreshCalendar');
    }

    public function render()
    {
        return view('livewire.full-calendar');
    }
}
