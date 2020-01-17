<?php

namespace Jhoule\Mailshake\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Jhoule\Mailshake\Errors\InternalError;
use Jhoule\Mailshake\Errors\MissingParameter;
use Jhoule\Mailshake\Errors\NotFound;

class MailshakeRequest
{
    protected $endpoint;

    protected $baseURL;

    public function __construct()
    {
        $this->baseURL = config('mailshake.endpoints.base');
    }

    /**
     * @param array $parameters
     *
     * @throws InternalError
     * @throws NotFound
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws MissingParameter
     *
     * @return object
     */
    public function sendRequest(array $parameters = []): object
    {
        $client = new Client();

        try {
            $response = $client->request('POST', $this->baseURL.$this->endpoint, [
                'auth'        => [config('mailshake.api-key'), ''],
                'form_params' => $parameters,
                'debug'       => config('mailshake.debug'),
            ]);
            Log::debug('Mailshake response: '.$response->getBody());
        } catch (ClientException $e) {
            Log::error($e->getMessage(), $e->getTrace());

            if ($e->getCode() === Response::HTTP_NOT_FOUND) {
                throw new NotFound($e->getMessage(), $e->getCode(), $e, time());
            } elseif (strpos($e->getMessage(), 'missing_parameter')) {
                throw new MissingParameter($e->getMessage(), $e->getCode(), $e, time());
            }

            throw $e;
        } catch (ServerException $e) {
            Log::error($e->getMessage(), $e->getTrace());

            throw new InternalError($e->getMessage(), $e->getCode(), $e, time());
        }

        return json_decode($response->getBody());
    }
}
