<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PlantId extends Component
{
    use WithFileUploads;

    public $api_key = '2b10FiRnqF3kK1anow3Ga9Y7e';
    public $ids = ['1', '2', '3', '4', '5'];
    public $organs = [];
    public $images = [];

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

    public function clearProperties()
    {
        $this->images = [];
        $this->organs = [];
    }

    public function changeOrgan($id)
    {
        unset($this->organs[$id]);
    }

    public function changeImage($id)
    {
        unset($this->images[$id]);
    }

    public function save()
    {
        $data = $this->validate();

        $baseName = substr(hash(
            'sha1',
            'cURL-php-multiple-value-same-key-support' . microtime()
        ), 0, 12);
        $boundary = '----------------------------' . $baseName;

        $body = array();
        $crlf = "\r\n";

        foreach ($data as $keys => $values) {
            if ($keys === 'organs') {
                foreach ($values as $value) {
                    $body[] = '--' . $boundary;
                    $body[] = 'Content-Disposition: form-data; name="' . $keys . '"';
                    $body[] = '';
                    $body[] = $value;
                }
            }

            if ($keys === 'images') {
                foreach ($values as $value) {
                    $body[] = '--' . $boundary;
                    $body[] = 'Content-Disposition: form-data; name="' . $keys . '"; filename="' . $value->getClientOriginalName() . '"';
                    $body[] = 'Content-Type: application/octet-stream';
                    $body[] = '';
                    $body[] = $value->get();
                }
            }
        }

        $body[] = '--' . $boundary . '--';
        $body[] = '';

        $contentType = 'multipart/form-data; boundary=' . $boundary;
        $content = join($crlf, $body);


        try {
            $response = Http::withHeaders([
                'Content-Length' => strlen($content),
                'Expect' => '100-continue',
            ])
                ->withBody($content, $contentType)
                ->post('https://my-api.plantnet.org/v2/identify/all?include-related-images=true&api-key=2b10FiRnqF3kK1anow3Ga9Y7e')
                ->json();

            session()->flash('flash.banner', 'Yay it works!');
            session()->flash('flash.bannerStyle', 'success');

            return $response;

        } catch (\Exception $e) {
            dump($e);
            return session()->flash('flash.banner', $e->getMessage());
            return session()->flash('flash.bannerStyle', 'danger');


        } catch (\Error $err) {
            dump($err);
            return session()->flash('error', 'Opps something went wrong!');

        }

        // Http::get('https://api.gbif.org/v1/species/' . $response['results'][0]['gbif']['id'] . '/descriptions')->json();

    }

    public function render()
    {
        return view('livewire.plant-id');
    }
}

    // public function save()
    // {

    //     dd($this->organs, $this->photos);
    //     $images = Storage::files('tree_id_photos');

    //     $this->validate([
    //         'photos.*' => 'image|max:1024', // 1MB Max
    //     ]);

    //     foreach ($this->photos as $key => $photo) {
    //         $this->photos[$key] = $photo->store('photos');
    //     }

    //     dd(json_encode($this->photos));

    //     
    // }
