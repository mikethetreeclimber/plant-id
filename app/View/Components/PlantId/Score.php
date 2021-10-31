<?php

namespace App\View\Components\PlantId;

use Illuminate\View\Component;

class Score extends Component
{
    public $score;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($score)
    {
        $this->score = number_format($score * 100, 1);
    }

    public function colorOfScore($score)
    {
        if ($score > 50.000) {
            return 'green';
        }
        if ($score < 50.000 && $score > 30.000) {
            return 'yellow';
        }
        if ($score < 30.000) {
            return 'red';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.plant-id.score');
    }
}
