<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ImageSlider extends Component
{
    public $images = [];
    public $currentImageIndex = 0;
    public $listeners = [
        'imageAdded' => 'pushImageToArray'
    ];

    public function mount($images)
    {
        $this->images = $images;
    }

    public function pushImageToArray($image)
    {
        dd($image);
        return array_push($this->images, $image);
    }

    public function back()
    {
        $count = count($this->images);
        if ($this->currentImageIndex === 0) {
            $this->currentImageIndex = $count - 1;
            return;
        }

        $this->currentImageIndex -= 1;
        return;
    }

    public function next()
    {
        $count = count($this->images);
        if ($this->currentImageIndex === $count - 1) {
            $this->currentImageIndex = 0;
            return;
        }

        $this->currentImageIndex += 1;
        return;
    }

   
    public function render()
    {
        return view('livewire.image-slider');
    }
}
