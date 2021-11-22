<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;
use App\Http\Livewire\Traits\HasImageSlider;
use App\Http\Livewire\Traits\MakesPlantIdRequest;

class PlantId extends Component
{
    use WithFileUploads;
    use MakesPlantIdRequest;
    use HasImageSlider;

    public $score;
    public $results;
    public $organs = [];
    public $images = [];
    public $imageUrls = [];
    public $colorOfScore;
    public $addImage = false;
    public $uploadingImages = true;
    public $api_key = '2b10FiRnqF3kK1anow3Ga9Y7e';

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
        $image = collect($images)
            ->diff($this->images);
        $key = key($image->toArray());
        $imageUrl = $image->first()->temporaryUrl();

        $this->imageUrls[$key] = $imageUrl;

        Cache::put($key, ['imageUrl' => $imageUrl]);

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

    public function getCache()
    {
        $this->results = Cache::get('results');
        if (isset($this->results)) {
            $this->uploadingImages = false;
        }
    }

    public function submit()
    {
        try {
            $this->results = $this->getResults();
            Cache::put('results', $this->results);
            Cache::put('uploaded', [$this->imageUrls, $this->organs]);
            $this->uploadingImages = false;
        } catch (\Throwable $e) {
            $this->emitSelf('hasErrors');
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.plant-id')
            ->layout('layouts.plant-id');
    }
}
