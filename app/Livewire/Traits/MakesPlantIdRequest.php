<?php

namespace App\Livewire\Traits;

trait MakesPlantIdRequest
{
    public function getResults(array $data): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://' . config('plantId.endpoint') . '/v2/identify/all?include-related-images=true',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ]);

        $this->setCurl($curl, $data);
        $rawResponse = curl_exec($curl);

        if ($rawResponse === false) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \ErrorException('Failed to connect to PlantNet API: ' . $error);
        }

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $response = json_decode($rawResponse);

        if ($response === null) {
            throw new \ErrorException('Invalid response from PlantNet API');
        }

        if ($statusCode === 200) {
            if (!isset($response->results) || !is_array($response->results)) {
                throw new \ErrorException('Unexpected response format from PlantNet API');
            }

            return collect($response->results)
                ->map(function ($result, $key) {
                    $commonName = $result->species->commonNames[0] ?? 'Unknown';
                    $scientificName = $result->species->scientificName ?? 'Unknown';
                    $scientificNameWithout = $result->species->scientificNameWithoutAuthor ?? $scientificName;
                    $gbifId = $result->gbif->id ?? null;

                    return collect([
                        $key,
                        number_format($result->score * 100, 1),
                        ucwords($commonName),
                        ucwords($scientificName),
                        ucwords($scientificNameWithout),
                        collect($result->images)->map(function ($image) {
                            return [
                                'imageUrl' => $image->url->m ?? '',
                                'organ' => $image->organ ?? '',
                                'citation' => $image->citation ?? '',
                                'date' => $image->date->string ?? '',
                            ];
                        }),
                        $gbifId,
                    ]);
                })->toArray();
        }

        if ($statusCode === 404) {
            $message = $response->message ?? 'Species not found';
            throw new \ErrorException($message . ', Please Add More Images and Resubmit');
        }

        throw new \ErrorException('Unexpected API response (HTTP ' . $statusCode . ')');
    }

    public function setCurl($curl, array $data): void
    {
        $algos = hash_algos();
        $hashAlgo = null;

        foreach (['sha1', 'md5'] as $preferred) {
            if (in_array($preferred, $algos)) {
                $hashAlgo = $preferred;
                break;
            }
        }

        if ($hashAlgo === null) {
            [$hashAlgo] = $algos;
        }

        $boundary = '----------------------------' . substr(hash(
            $hashAlgo,
            'cURL-php-multiple-value-same-key-support' . microtime()
        ), 0, 12);

        $body = [];
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

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Length: ' . $contentLength,
            'Expect: 100-continue',
            'Content-Type: ' . $contentType,
            'Api-Key: ' . config('plantId.secret'),
        ]);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    }
}
