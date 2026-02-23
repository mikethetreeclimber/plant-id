<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Traits\HasImageSlider;

class PlantIdResults extends Component
{
    use HasImageSlider;

    public $score;
    public $images;
    public $gbifId;
    public $resultId;
    public string $commonName = '';
    public string $scientificName = '';
    public string $scientificNameWithout = '';

    public function mount(...$result): void
    {
        [$spreadResult] = $result;
        [
            $this->resultId,
            $this->score,
            $this->commonName,
            $this->scientificName,
            $this->scientificNameWithout,
            $this->images,
            $this->gbifId
        ] = $spreadResult;
    }

    public function getColorOfScoreProperty(): string
    {
        if ($this->score > 50.0) {
            return 'success';
        }
        if ($this->score > 30.0) {
            return 'warning';
        }
        return 'error';
    }

    public function removeResult($resultId): void
    {
        $this->dispatch('removeResult', resultId: $resultId);
    }

    public function render()
    {
        return view('livewire.plant-id-results');
    }
}
