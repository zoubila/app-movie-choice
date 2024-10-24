<?php

namespace App\Service;

class MovieApiService
{
    private string $apiUrlBase = 'https://api.themoviedb.org/3/';
    private string $apiToken = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZDY0OThjYWQ4MjEyZTJmM2UzNzFhZWZiMmE3Y2Y5MSIsIm5iZiI6MTcyOTc3NTMwMi43NzUxMjksInN1YiI6IjY3MWEzZWIxMjdiZDU3ZDkxZjYyNTk1YyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.EqVq5Lwt6e9LjsBPDHbNElithGx__495CQL_U93G57E';

    public function makeApiRequest(string $endpoint, array $queryParams = []): array
    {
        $curl = curl_init();
        
        // Construire l'URL finale avec les paramètres de requête
        $url = $this->apiUrlBase . $endpoint . '?' . http_build_query($queryParams);

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->apiToken,
                "accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new \Exception('Erreur cURL : ' . $err);
        }

        return json_decode($response, true);
    }
}
