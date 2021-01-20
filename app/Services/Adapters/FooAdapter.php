<?php

namespace App\Services\Adapters;

use App\Exceptions\FooMovieServiceUnavailableException;
use App\Services\Transformers\FooResponseTransformer;
use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;
use External\Foo\Exceptions\ServiceUnavailableException;
use External\Foo\Movies\MovieService;

class FooAdapter extends BaseAdapter
{
    /** @var AuthWS */
    protected $loginService;

    /** @var MovieService */
    protected $movieService;

    /** @var FooResponseTransformer */
    protected $responseTransformer;

    public function __construct()
    {
        $this->loginService = new AuthWS();
        $this->movieService = new MovieService();
        $this->responseTransformer = new FooResponseTransformer();
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public function authenticate($login, $password)
    {
        try {
            $this->loginService->authenticate($login, $password);
        } catch (AuthenticationFailedException $e) {
            return false;
        }

        return true;
    }

    public function getTitles()
    {
        try {
            return $this->responseTransformer->transformMovieTitleResponse($this->movieService->getTitles());
        } catch (ServiceUnavailableException $e) {
            throw new FooMovieServiceUnavailableException('Can not get data from Foo movie service');
        }
    }
}
