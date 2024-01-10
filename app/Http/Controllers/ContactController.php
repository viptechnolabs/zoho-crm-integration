<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    private $authToken;
    private $module;

    public function __construct()
    {
        // Replace 'YOUR_AUTH_TOKEN' with your Zoho CRM auth token
        //$this->authToken = 'YOUR_AUTH_TOKEN';
        $this->module = 'Contacts'; // The module where contacts are stored
    }

    public function token()
    {
       // $this->authToken = 'token';
       // $this->authToken = $this->getZohoCRMToken();
        dd($this->authToken);
        return $this->authToken;
    }

    public function getZohoCRMToken() {
        $clientId = '1000.QB1UAF3F9VYS3LIGSCDCXSMKV8XSAU';
        $clientSecret = '36141f1a725c0be433f9da11e64330d672e2f3b8e8';
        $code = '1000.ad214aaef8b564421d3661d674edc046.4a291a3e8b87ed0d123a05d2fffe377b';

        // Zoho's token endpoint
        $url = 'https://accounts.zoho.in/oauth/v2/token';

        // Parameters required to get the access token
        $params = [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code
        ];

        try {
            $response = Http::asForm()->post($url, $params);

            if ($response->successful()) {
                $token = $response->json()['access_token'];
            //    Session()->put('token', $token);
              //  $this->authToken = $token;
                return $token;
            } else {
                // Handle error response
                return 'Token Error';
            }
        } catch (\Exception $e) {
            // Handle exception
            return $e->getMessage();
        }
    }

    public function listContacts()
    {
       // $token = $this->getZohoCRMToken();
        $token1 = '1000.c1f81ee37305d4316e1137262b534a29.dd1b10352b898525d235ca258ec61844';
        $this->authToken = $token1;
        //dd($this->authToken);
        /* $this->authToken = '1000.d49fda574006f6c7e3376817b70414b7.7b2180fb929c0457e2eee7b29f4664c0';
         dd($this->authToken);*/
        //dd($this->getZohoCRMToken(), $this->authToken);
        $client = new Client([
            'base_uri' => 'https://www.zohoapis.in/crm/v2/',
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $this->getZohoCRMToken(),
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->get($this->module);

            $statusCode = $response->getStatusCode();
            $contacts = json_decode($response->getBody(), true);

            // Handle the list of contacts
            if ($statusCode === 200) {
                return $contacts;
            } else {
                return "Failed to fetch contacts: {$statusCode}";
            }
        } catch (\Exception $e) {
            return "Error: {$e->getMessage()}";
        }
    }

    public function add()
    {
        return view('contact');
    }

    public function addContact(Request $request)
    {
//        $token = $this->getZohoCRMToken();
//        dd($token);
        $token1 = '1000.2fef22618731d49feee2b1bac1cb8723.560327247e98e8d5b697495f3fba8a32';
//        dd($token1);

        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $message = $request->input('message');

        $client = new Client([
            'base_uri' => 'https://www.zohoapis.com/crm/v2/',
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $token1,
                'Content-Type' => 'application/json',
            ],
        ]);

        $data = [
            "data" => [
                [
                    "First_Name" => $first_name,
                    "Last_Name" => $last_name,
                    "Email" => $email,
                    "Message" => $message,
                    // Add more fields as needed
                ]
            ]
        ];

        try {
            $response = $client->post($this->module, [
                'json' => $data,
            ]);
            dd($response);

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);
            dd($statusCode, $responseData);

            // Handle the response
            if ($statusCode === 201) {
                $contactId = $responseData['data'][0]['details']['id'];
                return "Contact created with ID: {$contactId}";
            } else {
                return "Failed to create contact: {$statusCode}";
            }
        } catch (\Exception $e) {
            return "Error: {$e->getMessage()}";
        }
    }

    public function updateContact($contactId)
    {
        $client = new Client([
            'base_uri' => 'https://www.zohoapis.com/crm/v2/',
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $this->authToken,
                'Content-Type' => 'application/json',
            ],
        ]);

        $data = [
            "data" => [
                [
                    "First_Name" => "Updated John",
                    // Add other fields to update
                ]
            ]
        ];

        try {
            $response = $client->put("{$this->module}/$contactId", [
                'json' => $data,
            ]);

            $statusCode = $response->getStatusCode();
            dd($statusCode, $response);

            // Handle the response
            if ($statusCode === 200) {
                return "Contact updated successfully";
            } else {
                return "Failed to update contact: {$statusCode}";
            }
        } catch (\Exception $e) {
            return "Error: {$e->getMessage()}";
        }
    }

    public function deleteContact($contactId)
    {
        $client = new Client([
            'base_uri' => 'https://www.zohoapis.com/crm/v2/',
            'headers' => [
                'Authorization' => 'Zoho-oauthtoken ' . $this->authToken,
                'Content-Type' => 'application/json',
            ],
        ]);

        try {
            $response = $client->delete("{$this->module}/$contactId");

            $statusCode = $response->getStatusCode();
            dd($statusCode, $response);

            // Handle the response
            if ($statusCode === 204) {
                return "Contact deleted successfully";
            } else {
                return "Failed to delete contact: {$statusCode}";
            }
        } catch (\Exception $e) {
            return "Error: {$e->getMessage()}";
        }
    }

   /* public function token()
    {
        $clientId = '1000.QB1UAF3F9VYS3LIGSCDCXSMKV8XSAU';
        $clientSecret = '36141f1a725c0be433f9da11e64330d672e2f3b8e8';
        $redirectUri = 'http://127.0.0.1:8000/token';

        // Zoho's token endpoint
        $url = 'https://accounts.zoho.in/oauth/v2/token';

        // Parameters required to get the access token
        $params = [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
//            'redirect_uri' => $redirectUri
//            'scope' => 'ZohoCRM.modules.all',
             'code' => '1000.c3dbc9eaea9eeb38dc45d02ea444223d.2b8c4d24c550cfdcf779b86419abda31'
        ];

        try {
            $response = Http::asForm()->post($url, $params);
            dd($response->json());

            if ($response->successful()) {
                $token = $response->json();
                dd($token);
                return $token;
            } else {
                dd('here');
                // Handle error response
                return null;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Handle exception
            return null;
        }

        dd('token');
        return view('contact');
    }*/
}
