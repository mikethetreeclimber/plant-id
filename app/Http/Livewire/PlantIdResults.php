<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\Livewire\Traits\HasImageSlider;

class PlantIdResults extends Component
{
    use HasImageSlider;

    public $score;
    public $images;
    public $gbifId;
    public $resultId;
    public $commonName = '';
    public $scientificName = '';
    public $scientificNameWithout = '';

    protected $listeners = [
        'refresh' => '$refresh'
    ];

    public function mount(...$result)
    {
        [$spreadResult] = $result;
        [
            $this->resultId,
            $this->score,
            $this->commonName,
            $this->scientificName,
            $this->scientificNameWithout,
            $this->images,
            $this->gbifId] = $spreadResult;
    }

    public function getColorOfScoreProperty()
    {
        if ($this->score > 50.0) {
             return 'green';
        }
        if ($this->score < 50.0 && $this->score > 30.0) {
             return 'yellow';
        }
        if ($this->score < 30.0) {
             return 'red';
        }
    }

    public function removeResult($resultId)
    {
        $this->emit('removeResult', $resultId);
    }

    public function render()
    {
        return view('livewire.plant-id-results');
    }
}
