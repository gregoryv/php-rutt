<?php
namespace gregoryv\rutt;

/**
 * CRUDMiddleware maps named resources
 */
class CRUDMiddleware extends AbstractMiddleware
{

  private $mux;

  public function __construct(MuxerInterface $mux) {
    $this->mux = $mux;
  }

  public function route($method, $uri, &$request,
                        ResponseWriterInterface &$response) {
    try {
      $route = $this->mux->match($method, $uri);
    } catch(HttpException $e) {
      $response->writeError($e);
      return;
    }
    $handler = $route->handler;

    // Maybe use factory here?
    if(is_string($handler)) {
      $handler = new $handler();
    }

    // Map http method to handler method
    switch ($method) {
    case 'PUT':
        // This is JSON specific
        $request = json_decode(file_get_contents("php://input"), true);
        $handler->create($request, $response);
      break;
    case 'GET':
      $handler->read($request, $response);
      break;
    case 'PATCH':
    case 'POST':
      $handler->update($request, $response);
      break;
    case 'DELETE':
      $handler->delete($request, $response);
      break;
    default:
      $response->writeError(new HttpException("Not Implemented", 501));
      return;
    }
    $this->next($method, $uri, $request, $response);
  }

}
