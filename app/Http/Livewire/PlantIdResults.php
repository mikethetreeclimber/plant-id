<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\HasImageSlider;
use Livewire\Component;

class PlantIdResults extends Component
{
    use HasImageSlider;

    public $score;
    public $images;
    public $spreadResult;
    public $commonName = '';
    public $scientificName = '';
    public $scientificNameWithout = '';

    public function mount(...$result)
    {
        [$this->spreadResult] = $result;
        [$this->score, $this->commonName, $this->scientificName, $this->scientificNameWithout, $this->images] = $this->spreadResult;
    }

    public function render()
    {
        return view('livewire.plant-id-results');
    }
}
