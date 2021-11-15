<?php

namespace App\Http\Livewire\Traits;


trait HasImageSlider
{
    public $currentImageIndex = 0;

    public function back()
    {
        if ($this->currentImageIndex === 0) {
            $this->currentImageIndex = count($this->images) - 1;
            return;
        }

        $this->currentImageIndex -= 1;
        return;
    }

    public function next()
    {
        if ($this->currentImageIndex === count($this->images) - 1) {
            $this->currentImageIndex = 0;
            return;
        }

        $this->currentImageIndex += 1;
        return;
    }

}
