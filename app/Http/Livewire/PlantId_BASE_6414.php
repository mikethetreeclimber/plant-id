<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ViewErrorBag;

class PlantId extends Component
{
    use WithFileUploads;

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
        $photo = array_pop($image);
        // dd($photo);
        $this->emitTo(SelectOrganModal::class, 'showModal', $photo->temporaryUrl());
    }

    public function organSelected($organ)
    {
        $this->organs[] = $organ;
        // $this->dispatchBrowserEvent('success', "the organ $organ has been successfully associated with the photo you have uploaded");
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

    public function getResponse($results)
    {
        $this->results = json_decode($results)->results;
    }

    public function makeRequest()
    {
        
        $data = $this->validate();


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://my-api.plantnet.org/v2/identify/all?include-related-images=true&api-key=2b10FiRnqF3kK1anow3Ga9Y7e',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ));

        $this->setCurl($curl, $data);
        $response = curl_exec($curl);
        curl_close($curl);

        $this->getResponse($response);
    }

    public function setCurl($curl, $data)
    {
        $algos = hash_algos();
        $hashAlgo = null;

        foreach (array('sha1', 'md5') as $preferred) {
            if (in_array($preferred, $algos)) {
                $hashAlgo = $preferred;
                break;
            }
        }

        if ($hashAlgo === null) {
            list($hashAlgo) = $algos;
        }

        $boundary = '----------------------------' . substr(hash(
            $hashAlgo,
            'cURL-php-multiple-value-same-key-support' . microtime()
        ), 0, 12);

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


        $contentLength = strlen($content);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Length: ' . $contentLength,
            'Expect: 100-continue',
            'Content-Type: ' . $contentType
        ));

        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    }

    public function render()
    {
        return view('livewire.plant-id')
            ->layout('layouts.plant-id');
    }
}