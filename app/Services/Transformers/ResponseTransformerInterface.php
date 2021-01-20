<?php

namespace App\Services\Transformers;

interface ResponseTransformerInterface
{
    public function transformMovieTitleResponse($responseData);
}
