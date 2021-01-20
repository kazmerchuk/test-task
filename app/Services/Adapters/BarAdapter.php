<?php

namespace App\Services\Adapters;

use App\Exceptions\BarMovieServiceUnavailableException;
use App\Services\Transformers\BarResponseTransformer;
use External\Bar\Auth\LoginService;
use External\Bar\Exceptions\ServiceUnavailableException;
use External\Bar\Movies\MovieService;

class BarAdapter extends BaseAdapter
{
    /** @var LoginService */
    protected $loginService;

    /** @var MovieService */
    protected $movieService;

    /** @var BarResponseTransformer */
    protected $responseTransformer;

    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->movieService = new MovieService();
        $this->responseTransformer = new BarResponseTransformer();
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public function authenticate($login, $password)
    {
        return $this->loginService->login($login, $password);
    }

    public function getTitles()
    {
        try {
            return $this->responseTransformer->transformMovieTitleResponse($this->movieService->getTitles());
        } catch (ServiceUnavailableException $e) {
            throw new BarMovieServiceUnavailableException('Can not get data from Bar movie service');
        }
    }
}
