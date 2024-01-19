<?php

    require_once 'vendor/autoload.php';

    use MercadoPago\Exceptions\MPApiException;
    use MercadoPago\MercadoPagoConfig;
    use MercadoPago\Client\PreApproval\PreApprovalClient;

    MercadoPagoConfig::setAccessToken('APP_USR-4642861700825580-121223-cb60bb4bd08630567344cbd703208047-1589659827');

    $client = new PreApprovalClient();
    $payload = json_decode(file_get_contents('php://input'), true);

    try {
        $request = [
            'back_url' => 'https://www.mercadopago.com.br',
            'preapproval_plan_id' => $payload['id_plano'],
            'card_token_id' => $payload['token'],
            'external_reference' => '23546246234',
            'payer_email' => $payload['payer']['email'],
            'status' => 'authorized'
        ];

        $payment = $client->create($request);
        echo $payment->id;
    } catch (MPApiException $e) {
        $groupErrors = "";

        foreach ($e->getApiResponse()->getContent() as $key => $errors) {
            $groupErrors .= "\n".$errors;
        }

        echo "Ocorreu um erro no pagamento, {$groupErrors}";
    } catch (\Exception $e) {
        echo $e->getMessage();
    }