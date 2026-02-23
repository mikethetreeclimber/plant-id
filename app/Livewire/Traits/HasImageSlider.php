<?php

namespace App\Livewire\Traits;

trait HasImageSlider
{
    public int $currentImageIndex = 0;

    public function back(): void
    {
        if ($this->currentImageIndex === 0) {
            $this->currentImageIndex = count($this->images) - 1;
            return;
        }

        $this->currentImageIndex -= 1;
    }

    public function next(): void
    {
        if ($this->currentImageIndex === count($this->images) - 1) {
            $this->currentImageIndex = 0;
            return;
        }

        $this->currentImageIndex += 1;
    }
}
