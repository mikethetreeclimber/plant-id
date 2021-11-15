<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Livewire\Traits\HasImageSlider;
use App\Http\Livewire\Traits\MakesPlantIdRequest;

class PlantId extends Component
{
    use WithFileUploads;
    use MakesPlantIdRequest;
    use HasImageSlider;

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
        $image = collect($images)->diff($this->images)->first();
        
        $this->selectOrgan($image->temporaryUrl());
    }

    public function selectOrgan($photoUrl)
    {
        $this->emitTo(SelectOrganModal::class, 'showModal', $photoUrl);
    }

    public function organSelected($organ)
    {
        $this->organs[] = $organ;
        // $this->dispatchBrowserEvent('success', "the organ $organ has been successfully associated with the photo you have uploaded");
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