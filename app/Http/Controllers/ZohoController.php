<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ZohoController extends Controller
{
    public function login(Request $request)
    {
        try {
            $clientId = env("ZOHO_CLIENT_ID");
            $clientSecret = env("ZOHO_CLIENT_SECRET");
            $code = env("ZOHO_CODE");
            $response = Http::asForm()->post("https://accounts.zoho.in/oauth/v2/token", [
                'grant_type' => "authorization_code",
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
            ]);
            $arr = $response->json();

            $access_token = $arr["access_token"];
            $refresh_token = $arr["refresh_token"];

            Cache::put("access_token",$access_token,6000);
            Cache::put("refresh_token",$refresh_token,6000);

            return redirect()->route("list");
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function refreshToken()
    {
        try {
            $clientId = env("ZOHO_CLIENT_ID");
            $clientSecret = env("ZOHO_CLIENT_SECRET");
            $refresh_token = Cache::get("refresh_token");
            $response = Http::asForm()->post("https://accounts.zoho.in/oauth/v2/token", [
                'refresh_token' => $refresh_token,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => "refresh_token",
            ]);
            $arr = $response->json();
            $access_token = $arr["access_token"];
            Cache::put("access_token",$access_token,6000);
            return $access_token;
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function tokens(Request $request)
    {
        $access_token = Cache::get("access_token");
        $refresh_token = Cache::get("refresh_token");
        $tokens = ["access_token"=>$access_token,"refresh_token"=>$refresh_token];
    }

    public function list(Request $request)
    {
        try {
            $access_token = $this->refreshToken();
            $response = Http::withHeaders([
                'Authorization' => 'Zoho-oauthtoken ' . $access_token,
                'Content-Type' => 'application/json',
            ])->get('https://www.zohoapis.in/crm/v2/Contacts');
            $data = $response->json();
            dd($data);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }

    }

    public function details($id)
    {
        try {
            $access_token = $this->refreshToken();
            $response = Http::withHeaders([
                'Authorization' => 'Zoho-oauthtoken ' . $access_token,
                'Content-Type' => 'application/json',
            ])->get('https://www.zohoapis.in/crm/v2/Contacts/' . $id);

            $data = $response->json();
            return $data['data'][0];
            dd($data['data'][0]);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }

    }

    public function add(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $message = $request->input('message');

        try {
            $access_token = $this->refreshToken();
            $data = [
                "data" => [
                    [
                        "First_Name" => $first_name,
                        "Last_Name"=>$last_name,
                        "Email"=>$email,
                        "Description"=>$message
                    ]
                ]
            ];
            $response = Http::withHeaders([
                'Authorization' => 'Zoho-oauthtoken ' . $access_token,
                'Content-Type' => 'application/json',
            ])->post('https://www.zohoapis.in/crm/v2/Contacts',$data);
            $data = $response->json();
            dd($data['data'][0]);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }

    }

    public function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $details = $this->details($id);
        return view('edit-contact', compact('details'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $message = $request->input('message');

        try {
            $access_token = $this->refreshToken();
            $data = [
                "data" => [
                    [
                        "First_Name" => $first_name,
                        "Last_Name"=>$last_name,
                        "Email"=>$email,
                        "Description"=>$message
                    ]
                ]
            ];
            $response = Http::withHeaders([
                'Authorization' => 'Zoho-oauthtoken ' . $access_token,
                'Content-Type' => 'application/json',
            ])->put('https://www.zohoapis.in/crm/v2/Contacts/' . $id, $data);

            $data = $response->json();
            dd($data['data'][0]);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }

    }
}
