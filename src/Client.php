<?php
namespace InfraDigital\ApiClient;

use InfraDigital\ApiClient\Constants\Constants;
use InfraDigital\ApiClient\Adapter;

class Client extends BaseClient
{
    /**
     * @var Adapter\StudentAdapter
     */
    private $studentApi;

    public function __construct($username, $plainPassword)
    {
        parent::__construct($username, $plainPassword);
        $this->initAdapter();
    }

    private function initAdapter()
    {
        $this->studentApi = new Adapter\StudentAdapter($this->mainEntity, $this->utils);
    }

    /**
     * @return Adapter\StudentAdapter
     */
    public function studentApi()
    {
        return $this->studentApi;
    }
}