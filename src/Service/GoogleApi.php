<?php


namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GoogleApi
{
    /**
     * @var
     */
    private $key;

    public function __construct(ParameterBagInterface $googleApiKey)
    {
        $this->key = $googleApiKey->get('google_map_api_key');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function request($query)
    {
        $ch = curl_init();
        $data = [
            'query' => $query,
            'inputtype' => 'textquery',
            'fields' => 'photos,formatted_address,name,rating,opening_hours,geometry/location',
            'language' => 'fr',
            'key' => $this->key,
        ];
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => http_build_query(
                    $data
                ),
            ]
        );

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function autocomplete($query)
    {
        $ch = curl_init();
        $data = [
            'input' => $query,
            'types' => 'establishment',
            'language' => 'fr',
            'key' => $this->key,
        ];

        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => 'https://maps.googleapis.com/maps/api/place/autocomplete/json',
                CURLOPT_POSTFIELDS => http_build_query(
                    $data
                ),
            ]
        );

        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);

        return $response;
    }
}
