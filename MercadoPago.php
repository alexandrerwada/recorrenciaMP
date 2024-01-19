
<?php

require_once 'vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\PreApprovalPlan\PreApprovalPlanClient;
use MercadoPago\Net\MPSearchRequest;

class MercadoPago
{
    private $accessToken = 'APP_USR-4642861700825580-121223-cb60bb4bd08630567344cbd703208047-1589659827';

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
