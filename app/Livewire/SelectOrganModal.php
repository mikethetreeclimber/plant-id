<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class SelectOrganModal extends Component
{
    public string $imageUrl = '';
    public bool $selectOrgan = false;
    public array $organIcons = [
        'bark',
        'flower',
        'fruit',
        'leaf',
        'habit',
        'other',
    ];

    #[On('showModal')]
    public function showModal(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
        $this->selectOrgan = true;
    }

    public function addSelectedOrgan(string $organ): void
    {
        $this->dispatch('organSelected', organ: $organ);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.select-organ-modal');
    }
}
