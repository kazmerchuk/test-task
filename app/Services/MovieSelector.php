<?php

namespace App\Services;

use App\Services\Adapters\BarAdapter;
use App\Services\Adapters\BazAdapter;
use App\Services\Adapters\FooAdapter;

class MovieSelector
{
    /**
     * @return array
     */
    public function getTitles()
    {
        $finishTitleList = [];

        /**
         * @var BarAdapter|BazAdapter|FooAdapter $sourceProvider
         */
        foreach ($this->getSupportedProviderList() as $sourceProvider) {
            if (true === $this->isProviderResponseFresh($sourceProvider)) {
                $providerTitleList = $this->getProviderDataFromCache($sourceProvider);
            } else {
                $providerTitleList = $this->getProviderTitleList($sourceProvider);
                $this->writeProviderDataToCache($sourceProvider, $providerTitleList);
            }

            $finishTitleList = array_merge($finishTitleList, $providerTitleList);
        }

        return $finishTitleList;
    }

    /**
     * @param $sourceProvider
     * @return mixed
     */
    protected function getProviderTitleList($sourceProvider) {
        // @todo here we can add some kind of mechanism for retry

        return (new $sourceProvider())->getTitles();
    }

    /**
     * @return array
     */
    protected function getSupportedProviderList()
    {
        return [
            BarAdapter::class,
            BazAdapter::class,
            FooAdapter::class,
        ];
    }

    /**
     * @param $providerName
     * @return bool
     */
    protected function isProviderResponseFresh($providerName)
    {
        // @todo here we can check if provider data in cache and fresh
        return false;
    }

    /**
     * @param $providerName
     * @return array
     */
    protected function getProviderDataFromCache($providerName)
    {
        // @todo implement any kind of cache service here
        return [];
    }

    /**
     * @param $providerName
     * @param $data
     * @return bool
     */
    protected function writeProviderDataToCache($providerName, $data)
    {
        // @todo write data to cache
        return true;
    }
}
