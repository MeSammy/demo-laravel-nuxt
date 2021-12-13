<?php

namespace App\Http\Controllers;

use Error;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TMDBController extends Controller
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('TMDB_URL')]);
    }

    /**
     * Show a list of all movies.
     *
     * @return Response
     */
    public function getMovies(Request $request)
    {
        $page = $request->get('page', 1);
        $params = [
            'headers' => [
                'Authorization' => 'Bearer ' . env('TMDB_APP_TOKEN'),
                'Content-Type' => 'application/json',
            ],
            'query' => 'page=' . $page
        ];

        try {
            $response =
                json_decode($this->client->request('GET', '/3/trending/movie/week', $params)->getBody(), true);
            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Something went wrong.'
            ], 422);
        }
    }

    /**
     * Show a list of all movies.
     *
     * @return Response
     */
    public function getMoviesByQuery(Request $request)
    {
        $query = $request->get('search');
        $params = [
            'headers' => [
                'Authorization' => 'Bearer ' . env('TMDB_APP_TOKEN'),
                'Content-Type' => 'application/json',
            ],
            'query' => 'query=' . $query
        ];

        try {
            $response =
                json_decode($this->client->request('GET', '/3/search/movie', $params)->getBody(), true);
            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Something went wrong.'
            ], 422);
        }
    }

    /**
     * Show movie detail.
     *
     * @return Response
     */
    public function getMoviesById(Request $request)
    {
        $id = $request->get('movieId');

        try {
            $params = [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('TMDB_APP_TOKEN'),
                    'accept' => 'application/json',
                ],
            ];
            $response =
                json_decode($this->client->request('GET', '/3/movie/' . $id, $params)->getBody(), true);

            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Something went wrong.'
            ], 422);
        }
    }
}
