<?php

namespace App\Services\Transformers;

class BarResponseTransformer
{
    /**
     * @param $responseData
     * @return array
     */
    public function transformMovieTitleResponse($responseData)
    {
        $titleList = [];
        foreach ($responseData['titles'] as $titleData) {
            $titleList[] = $titleData['title'];
        }

        return $titleList;
    }
}
