<?php

namespace App\View\Components\PlantId;

use Illuminate\View\Component;

class SelectOrganModal extends Component
{
    public $id;
    public $image;
    public $organIcons = [
        'bark.png',
        'flower.png',
        'fruit.png',
        'leaf.png',
        'other.png',
        'habit.png'
    ];
    public $organIconsPath = 'storage/icons/plant-id/organs/';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $image)
    {
        $this->id = $id;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.plant-id.select-organ-modal');
    }
}
