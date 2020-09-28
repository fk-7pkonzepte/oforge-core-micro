<?php

namespace Oforge\Engine\Core\Abstracts;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AbstractController
 *
 * @package Oforge\Engine\Core\Abstracts
 */
abstract class AbstractController {

    /**
     * Prepare json response with json header, status code 200 and content data.
     *
     * @param Request $request
     * @param Response $response
     * @param array $data
     *
     * @return Response
     */
    protected function json(Request $request, Response $response, array $data) : Response {
        return $response->withStatus(200)->withHeader('Content-Type', 'application/json')->withJson($data);
    }

}
