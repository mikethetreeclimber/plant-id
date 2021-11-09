<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Http\Livewire\Traits\MakesPlantIdRequest;

class PlantId extends Component
{
    use WithFileUploads;
    use MakesPlantIdRequest;

    public $api_key = '2b10FiRnqF3kK1anow3Ga9Y7e';
    public $addImage = false;
    public $ids = ['0', '1', '2', '3', '4',];
    public $organs = [];
    public $images = [];
    public $results;
    public $listeners = [
        'organSelected'
    ];



    public function rules()
    {
        $keys = [];
        $values = [];
        foreach ($this->ids as $key) {
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

    public function updatedImages($image)
    {
        $this->selectOrgan(array_pop($image)->temporaryUrl());
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
    }

    public function changeImage($id)
    {
        unset($this->images[$id]);
        unset($this->organs[$id]);
    }

    public function getResponse($results)
    {
        $this->results = json_decode($results)->results;
    }

    public function render()
    {
        return view('livewire.plant-id')
            ->layout('layouts.plant-id');
    }
}