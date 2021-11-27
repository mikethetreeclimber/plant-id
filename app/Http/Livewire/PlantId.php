<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;
use App\Http\Livewire\Traits\HasImageSlider;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use App\Http\Livewire\Traits\MakesPlantIdRequest;
use Illuminate\Validation\ValidationException;
use Livewire\TemporaryUploadedFile;
use Spatie\ImageOptimizer\Image;
use Spatie\ImageOptimizer\OptimizerChain;

class PlantId extends Component
{
    use WithFileUploads;
    use MakesPlantIdRequest;
    use HasImageSlider;

    public $results;
    public $organs = [];
    public $images = [];
    public $uploadingImages = true;

    protected $listeners = [
        'organSelected',
        'removeResult',
        'refresh' => '$refresh'
    ];

    public function rules()
    {
        $keys = [];
        $values = [];
        foreach (array_keys($this->images) as $key) {
            $values[] = 'sometimes|required|mimes:jpeg,png,jpg|max:6250665';
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
        $image = collect($images)
            ->diff($this->images)
            ->first();

        $optimizing = OptimizerChainFactory::create();
        $optimizing->optimize($image->path());
        $this->images[] = $image;

        $this->selectOrgan($image->temporaryUrl());
    }

    public function selectOrgan($imageUrl)
    {
        $this->emitTo(SelectOrganModal::class, 'showModal', $imageUrl);
    }

    public function organSelected($organ)
    {
        $this->organs[] = $organ;
    }

    public function clearProperties()
    {
        $this->reset();
    }

    public function removeResult($resultId)
    {
        unset($this->results[$resultId]);
        $this->emit('refresh');
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
            $data = $this->validate();
            $this->results = $this->getResults($data);
            $this->uploadingImages = false;
        } catch (ValidationException $e) {
            $this->emitSelf('hasErrors');
            throw $e;
        } catch (\ErrorException $e) {
            $this->addError('error', $e->getMessage());
            $this->emitSelf('hasErrors');
        }
    }

    public function render()
    {
        return view('livewire.plant-id')
            ->layout('layouts.plant-id');
    }
}
