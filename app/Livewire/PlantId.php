<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Livewire\Traits\HasImageSlider;
use App\Livewire\Traits\MakesPlantIdRequest;
use Illuminate\Validation\ValidationException;
use Spatie\ImageOptimizer\OptimizerChainFactory;

#[Layout('components.layouts.app')]
class PlantId extends Component
{
    use WithFileUploads;
    use MakesPlantIdRequest;
    use HasImageSlider;

    public $results;
    public array $organs = [];
    public array $images = [];
    public bool $uploadingImages = true;

    public function rules(): array
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

    public function updatingImages($images): void
    {
        $image = collect($images)
            ->diff($this->images)
            ->first();

        $optimizing = OptimizerChainFactory::create();
        $optimizing->optimize($image->path());
        $this->images[] = $image;

        $this->selectOrgan($image->temporaryUrl());
    }

    public function selectOrgan(string $imageUrl): void
    {
        $this->dispatch('showModal', imageUrl: $imageUrl)->to(SelectOrganModal::class);
    }

    #[On('organSelected')]
    public function organSelected(string $organ): void
    {
        $this->organs[] = $organ;
    }

    public function clearProperties(): void
    {
        $this->reset();
    }

    #[On('removeResult')]
    public function removeResult(int $resultId): void
    {
        unset($this->results[$resultId]);
    }

    public function changeOrgan(int $id): void
    {
        unset($this->organs[$id]);
        $this->selectOrgan($this->images[$id]);
    }

    public function changeImage(int $id): void
    {
        unset($this->images[$id]);
        unset($this->organs[$id]);
    }

    public function submit(): void
    {
        try {
            $data = $this->validate();
            $this->results = $this->getResults($data);
            $this->uploadingImages = false;
        } catch (ValidationException $e) {
            $this->dispatch('hasErrors');
            throw $e;
        } catch (\ErrorException $e) {
            $this->addError('error', $e->getMessage());
            $this->dispatch('hasErrors');
        }
    }

    public function render()
    {
        return view('livewire.plant-id');
    }
}
