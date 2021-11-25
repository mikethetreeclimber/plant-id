<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class SelectOrganModal extends Component
{
    public $imageUrl = '';
    public $selectOrgan = false;
    public $organIcons = [
        'bark',
        'flower',
        'fruit',
        'leaf',
        'habit',
        'other'
    ];
    public $listeners = [ 
        'showModal'
    ];

    public function showModal($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        $this->selectOrgan = true;
    }

    public function addSelectedOrgan($organ)
    {
        $this->emit('organSelected', $organ);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.select-organ-modal');
    }
}
