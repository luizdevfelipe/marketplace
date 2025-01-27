<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Resources\Preference;

class MercadoPagoService
{
    public function __construct()
    {
        // Getting the access token from .env file
        $mpAccessToken = config('mercadopago.access_token');
        // Set the token the SDK's config
        MercadoPagoConfig::setAccessToken($mpAccessToken);
        //  Set the runtime enviroment to LOCAL if you want to test on localhost. Default value is set to SERVER
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    // Function that will return a request object to be sent to Mercado Pago API
    function createPreferenceRequest($items, $payer): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],
            "installments" => 12,
            "default_installments" => 1
        ];

        $backUrls = array(
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failed')
        );

        $request = [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => config('app.name'),
            "external_reference" => "1234567890",
            "expires" => false,
            "auto_return" => 'all',
        ];

        return $request;
    }

    public function createPaymentPreference(array $products): ?Preference
    {
        foreach ($products as $product) {
            $items[] = [
                "id" => $product['id'],
                "title" => $product['name'],
                "description" => $product['description'],
                "currency_id" => "BRL",
                "quantity" => $product['quantity'],
                "unit_price" => $product['price']
            ];
        }

        // Retrieve information about the user
        $user = Auth::user();

        $payer = array(
            "name" => $user->name,
            "surname" => $user->lastname,
            "email" => $user->email,
        );

        // Create the request object to be sent to the API when the preference is created
        $request = $this->createPreferenceRequest($items, $payer);

        // Instantiate a new Preference Client
        $client = new PreferenceClient();

        try {
            // Send the request that will create the new preference for user's checkout flow
            $preference = $client->create($request);

            // Useful props you could use from this object is 'init_point' (URL to Checkout Pro) or the 'id'
            return $preference;
        } catch (MPApiException $error) {
            // Here you might return whatever your app needs.
            // We are returning null here as an example.
            return null;
        }
    }
}
