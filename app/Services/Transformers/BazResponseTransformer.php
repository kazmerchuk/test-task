<?php

namespace App\Services\Transformers;

class BazResponseTransformer
{
    /**
     * @param $responseData
     * @return array
     */
    public function transformMovieTitleResponse($responseData)
    {
        $titleList = [];
        foreach ($responseData['titles'] as $titleData) {
            $titleList[] = $titleData;
        }

        return $titleList;
    }
}
