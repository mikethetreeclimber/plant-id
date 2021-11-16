<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class SelectOrganModal extends Component
{
    public $imageUrl = '';
    public $currentKey;
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

    public function showModal($key)
    {
        $this->currentKey = $key;
        $this->imageUrl = Cache::get($this->currentKey)['imageUrl'];

        $this->selectOrgan = true;
    }

    public function addSelectedOrgan($organ)
    {
        Cache::put($this->currentKey, [
            'imageUrl' => $this->imageUrl, 
            'organ' => $organ
        ]);
        $this->emitTo(PlantId::class, 'organSelected', $this->currentKey);
        $this->reset();
    }

    public function render()
    {
        return view('livewire.select-organ-modal');
    }
}
