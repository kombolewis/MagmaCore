<?php
namespace Magma\Http;

use Symfony\Component\HttpFoundation\Response;


class ResponseHandler
{
  public function handler() :Response {

    if(!isset($response)) {
      $response = new Response();
      if($response) return $response;
    }

    return false;
  }
}

