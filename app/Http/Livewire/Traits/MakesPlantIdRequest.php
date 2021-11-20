<?php

namespace App\Http\Livewire\Traits;

trait MakesPlantIdRequest
{
    public function makeBody($data)
    {
        dd(...$data);
    }

    public function getResults()
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

        return collect(json_decode($response)->results)
            ->map(function ($result) {
                return collect([
                    number_format($result->score * 100, 1),
                    ucwords($result->species->commonNames[0]),
                    ucwords($result->species->scientificName),
                    ucwords($result->species->scientificNameWithoutAuthor),
                    collect($result->images)->map(function ($image) {
                        return  [
                            'imageUrl' => $image->url->m,
                            'organ' => $image->organ,
                            'citation' => $image->citation,
                            'date' => $image->date->string
                        ];
                    })
                ]);
            })->toArray();
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
}
