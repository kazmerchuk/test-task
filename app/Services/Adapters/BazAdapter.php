<?php

namespace App\Services\Adapters;

use App\Exceptions\BazMovieServiceUnavailableException;
use App\Services\Transformers\BazResponseTransformer;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;
use External\Baz\Exceptions\ServiceUnavailableException;
use External\Baz\Movies\MovieService;

class BazAdapter extends BaseAdapter
{
    /** @var Authenticator */
    protected $loginService;
    /** @var MovieService */
    protected $movieService;
    /** @var BazResponseTransformer */
    protected $responseTransformer;

    public function __construct()
    {
        $this->loginService = new Authenticator();
        $this->movieService = new MovieService();
        $this->responseTransformer = new BazResponseTransformer();
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public function authenticate($login, $password)
    {
        $response = $this->loginService->auth($login, $password);
        if ($response instanceof Success) {
            return true;
        }

        return false;
    }

    public function getTitles()
    {
        try {
            return $this->responseTransformer->transformMovieTitleResponse($this->movieService->getTitles());
        } catch (ServiceUnavailableException $e) {
            throw new BazMovieServiceUnavailableException('Can not get data from Baz movie service');
        }
    }
}
