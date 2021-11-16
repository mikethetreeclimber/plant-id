<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;
use App\Http\Livewire\Traits\MakesPlantIdRequest;

class PlantId extends Component
{
    use WithFileUploads;
    use MakesPlantIdRequest;

    public $api_key = '2b10FiRnqF3kK1anow3Ga9Y7e';
    public $addImage = false;
    public $organs = [];
    public $images = [];
    public $uploadingImages = true;
    public $results;
    public $score;
    public $colorOfScore;
    public $listeners = [
        'organSelected'
    ];

    public function rules()
    {
        $keys = [];
        $values = [];
        foreach (array_keys($this->images) as $key) {
            $values[] = 'sometimes|required|mimes:jpeg,png|max:10400';
            $keys[] = 'images.' . $key;
            $values[] = 'required_with:images.' . $key;
            $keys[] = 'organs.' . $key;
        }

        $keys[] = 'organs';
        $values[] = 'array|min:1|max:5';
        $keys[] = 'images';
        $values[] = 'array|min:1|max:5';

        return array_combine($keys, $values);
    }

    public function updatingImages($images)
    {
        $key = key(collect($images)
            ->diff($this->images)
            ->toArray());

        Cache::put($key, ['imageUrl' => collect($images)
            ->diff($this->images)
            ->first()
            ->temporaryUrl()]);
        
        $this->selectOrgan($key);
    }

    public function selectOrgan($key)
    {
        $this->emitTo(SelectOrganModal::class, 'showModal', $key);
    }

    public function organSelected($key)
    {
        $this->organs[] = Cache::get($key)['organ'];
        $this->emitTo(ImageSlider::class, 'imageAdded', $key);
    }

    public function clearProperties()
    {
        $this->reset();
    }

    public function changeOrgan($id)
    {
        unset($this->organs[$id]);
        $this->selectOrgan($this->images[$id]);
    }

    public function changeImage($id)
    {
        unset($this->images[$id]);
        unset($this->organs[$id]);
    }

    public function submit()
    {
        try {
            $this->results = $this->getResults();
        } catch (\Throwable $e) {
            $this->emitSelf('hasErrors');
            throw $e;
        }

        if (isset($this->results)) {
            $this->uploadingImages = false;
        }
    }

    public function render()
    {
        return view('livewire.plant-id')
            ->layout('layouts.plant-id');
    }
}