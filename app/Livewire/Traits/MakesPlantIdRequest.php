<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\Http;

trait MakesPlantIdRequest
{
    public function getResults(array $data): array
    {
        $request = Http::timeout(30)
            ->connectTimeout(10)
            ->withHeaders(['Api-Key' => config('plantId.secret')]);

        foreach ($data['images'] as $image) {
            $request = $request->attach('images', $image->get(), $image->getClientOriginalName());
        }

        foreach ($data['organs'] as $organ) {
            $request = $request->attach('organs', $organ);
        }

        $response = $request->post(
            'https://' . config('plantId.endpoint') . '/v2/identify/all?include-related-images=true'
        );

        if ($response->failed()) {
            if ($response->status() === 404) {
                $message = $response->json('message', 'Species not found');
                throw new \ErrorException($message . ', Please Add More Images and Resubmit');
            }

            throw new \ErrorException('Unexpected API response (HTTP ' . $response->status() . ')');
        }

        $results = $response->json('results');

        if (!is_array($results)) {
            throw new \ErrorException('Unexpected response format from PlantNet API');
        }

        return collect($results)
            ->map(function ($result, $key) {
                $species = $result['species'] ?? [];
                $commonNames = $species['commonNames'] ?? [];
                $commonName = $commonNames[0] ?? 'Unknown';
                $scientificName = $species['scientificName'] ?? 'Unknown';
                $scientificNameWithout = $species['scientificNameWithoutAuthor'] ?? $scientificName;
                $gbifId = $result['gbif']['id'] ?? null;

                return collect([
                    $key,
                    number_format($result['score'] * 100, 1),
                    ucwords($commonName),
                    ucwords($scientificName),
                    ucwords($scientificNameWithout),
                    collect($result['images'] ?? [])->map(function ($image) {
                        return [
                            'imageUrl' => $image['url']['m'] ?? '',
                            'organ' => $image['organ'] ?? '',
                            'citation' => $image['citation'] ?? '',
                            'date' => $image['date']['string'] ?? '',
                        ];
                    }),
                    $gbifId,
                ]);
            })->toArray();
    }
}
