<?php

namespace App\Services\Transformers;

class FooResponseTransformer implements ResponseTransformerInterface
{
    /**
     * @param $responseData
     * @return mixed
     */
    public function transformMovieTitleResponse($responseData)
    {
        return $responseData;
    }
}
