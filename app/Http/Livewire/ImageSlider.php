<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class ImageSlider extends Component
{
    public $imageUrls = [];
    public $organs = [];
    public $currentImageIndex = 0;
    public $listeners = [
        'imageAdded' => 'pushImageToArray'
    ];

    public function pushImageToArray($key)
    {
        $imageOrgan = Cache::get($key);
        [$imageUrl, $organ] = [$imageOrgan['imageUrl'], $imageOrgan['organ']];
        array_push($this->imageUrls, $imageUrl);
        array_push($this->organs, $organ);
    }

    public function back()
    {
        $count = count($this->imageUrls);
        if ($this->currentImageIndex === 0) {
            $this->currentImageIndex = $count - 1;
            return;
        }

        $this->currentImageIndex -= 1;
        return;
    }

    public function next()
    {
        $count = count($this->imageUrls);
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
