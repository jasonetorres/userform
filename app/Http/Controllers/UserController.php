<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Appwrite\Client;
use Appwrite\Services\Databases;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $client = new Client();
        $client
            ->setEndpoint(env('APPWRITE_ENDPOINT'))
            ->setProject(env('APPWRITE_PROJECT_ID'))
            ->setKey(env('APPWRITE_API_KEY'));

        $databases = new Databases($client);

        try {
            $response = $databases->createDocument(
                env('APPWRITE_DATABASE_ID'),
                env('APPWRITE_COLLECTION_ID'),
                'unique()',
                [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ]
            );

            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}