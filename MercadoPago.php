
<?php

require_once 'vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\PreApprovalPlan\PreApprovalPlanClient;
use MercadoPago\Net\MPSearchRequest;

class MercadoPago
{
    private $accessToken = 'APP_USR-4818136613918222-120520-a3ce8b1f4f3fbf79ebbc5a1945547c2f-222698176';

    public function __construct()
    {
        MercadoPagoConfig::setAccessToken($this->accessToken);
    }

    public function obterPlanos()
    {
        $client = new PreApprovalPlanClient();
        $req = new MPSearchRequest(10, 0, ['status' => 'active']);
        $planos = $client->search($req);

        $content = $planos->getResponse()->getContent();
        $planos = $content['results'];

        return $planos;
    }
}
