<?php
namespace App\Http\Livewire;

use Livewire\Component;

class SelectOrganModal extends Component
{
    public $imageUrl = '';
    public $dataId;
    public $selectOrgan = false;
    public $organs = [];
    public $organIcons = [
        'bark',
        'flower',
        'fruit',
        'leaf',
        'habit',
        'other'
    ];
    public $organIconsPath = 'storage/icons/plant-id/organs/';

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
        $this->emitTo(PlantId::class, 'organSelected', $organ);
        $this->reset();

        // $this->selectOrgan = false;
    }

    public function render()
    {
        return view('livewire.select-organ-modal');
    }
}
