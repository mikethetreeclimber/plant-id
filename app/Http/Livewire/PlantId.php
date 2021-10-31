<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ViewErrorBag;

class PlantId extends Component
{
    use WithFileUploads;

    public $api_key = '2b10FiRnqF3kK1anow3Ga9Y7e';
    public $addImage = false;
    public $content;
    public $contentType;
    public $header;
    public $data = null;
    public $ids = ['0', '1', '2', '3', '4',];
    public $organs = [];
    public $images = [];
    public $results;
    public $score;
    public $scoreColor;


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

    public function getResponse()
    {

        $this->results = Cache::get('plant-id-response')['results'];
        foreach ($this->results as $key => $value) {
            $gbif = Http::get('https://api.gbif.org/v1/species/' . $value['gbif']['id'].'/name')->json();
                $this->results['gbif'][] = $gbif;
        }
        // dd($this->results['gbif']);
     
        return $this->results;
    }

    public function makeRequest()
    {

        try {
            $this->data = $this->validate();


            $baseName = substr(hash(
                'sha1',
                'cURL-php-multiple-value-same-key-support' . microtime()
            ), 0, 12);
            $boundary = '----------------------------' . $baseName;

            $body = array();
            $crlf = "\r\n";

            foreach ($this->data as $keys => $values) {
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

            $this->contentType = 'multipart/form-data; boundary=' . $boundary;
            $this->content = join($crlf, $body);
            $this->header = [
                'Content-Length' => strlen($this->content),
                'Expect' => '100-continue',
            ];


            $response = Http::withHeaders($this->header)
                ->withBody($this->content, $this->contentType)
                ->post('https://my-api.plantnet.org/v2/identify/all?include-related-images=true&api-key=2b10FiRnqF3kK1anow3Ga9Y7e')
                ->json();

            session()->flash('flash.banner', 'Yay it works!');
            session()->flash('flash.bannerStyle', 'success');
            Cache::put('plant-id-response', $response);
            dd($response);
            return $response;

            // foreach($result->images as $image){
            //             echo '<img src="'.$image->url->o.'"'.' style="width: 200px;"/>';
            //         }

        } catch (ValidationException $th) {
            $this->emitSelf('hasErrors');
            throw $th;
        }
    }

    public function render()
    {
        return view('livewire.plant-id')
            ->layout('layouts.plant-id');
    }
}
