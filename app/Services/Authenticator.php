<?php

namespace App\Services;

use App\Services\Adapters\BarAdapter;
use App\Services\Adapters\BazAdapter;
use App\Services\Adapters\FooAdapter;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use LogicException;

class Authenticator
{
    /**
     * @param $login
     * @param $password
     * @return bool|string
     */
    public function authenticate($login, $password)
    {
        try {
            $adapter = $this->getAuthenticationAdapter($login);
        } catch (LogicException $e) {
            return false;
        }

        $authenticationResult = $adapter->authenticate($login, $password);
        if ($authenticationResult) {
            return $this->generateToken($login);
        }

        return false;
    }

    /**
     * @param $login
     * @return string
     */
    protected function generateToken($login)
    {

        $builder = (new Builder())
            ->issuedBy(request()->getHost())
            ->permittedFor($this->getExternalServicePrefix($login))
            ->relatedTo($login);

        if (config('app.jwt_expires_in_min')) {
            $builder->expiresAt(time() + (config('app.jwt.expires_in_min') * 60));
        }

        return (string) $builder->getToken(new Sha256());
    }

    /**
     * @param $login
     * @return BarAdapter|BazAdapter|FooAdapter
     */
    protected function getAuthenticationAdapter($login)
    {
        $externalServicePrefix = $this->getExternalServicePrefix($login);
        switch ($externalServicePrefix) {
            case 'FOO':
                return new FooAdapter();
            case 'BAR':
                return new BarAdapter();
            case 'BAZ':
                return new BazAdapter();
        }

        throw new LogicException(sprintf('Unsupported authentication service'));
    }

    /**
     * @param $login
     * @return mixed
     */
    protected function getExternalServicePrefix($login)
    {
        return explode('_', $login)[0];
    }
}
