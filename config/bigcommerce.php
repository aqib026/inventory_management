<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Bigcommerce Api
    |--------------------------------------------------------------------------
    |
    | This file is for setting the credentials for bigcommerce api key and secret.
    |
    */
    'default' => env("BC_CONNECTION", 'oAuth'),


    'basicAuth' => [
        'store_url' => 'https://www.fashion-wholesalers.co.uk',//env("BC_STORE_URL", null),
        'username'  => 'aqib026',//env("BC_USERNAME", null),
        'api_key'   => 'b1a2f6f047278164164c9f74414c490ede4f03c7',//env("BC_API_KEY", null)
    ],

    'oAuth' => [
        'client_id'     => 'hhkyml8ihpcie3yqtkobzakrs2wpw9v',//env("BC_CLIENT_ID", null),
        'client_secret' => 'dwfba25hc0tw92r1ie71i71txmnhrwx',//env("BC_CLIENT_SECRET", null),
        'redirect_url'  => env("BC_REDIRECT_URL", null)
    ],

];