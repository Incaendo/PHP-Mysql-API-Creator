<?php

namespace App\Controller;

use Slim\Container;
use App\Component\ErrorMessageComponent as ErrorMessageComponent;
use Symfony\Component\Serializer\Serializer as Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder as XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder as JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer as GetSetMethodNormalizer;

/**
 * @file
 * Class BaseController
 * @author <<AUTHOR>>
 */
class BaseController {

  public function __construct(Container $c) {
    \Slim\Registry::setInstance($c);
    $encoders = array(new XmlEncoder(), new JsonEncoder());
    $normalizers = array(new GetSetMethodNormalizer());
    $this->serializer = new Serializer($normalizers, $encoders);
    $this->logger = $c->get('logger');
  }

  /*
   * Example $obj $jsonContent = $this->serialize($userRoleDTO, 'json');
   */

  public function serialize($object, $format = 'json') {
    return $jsonContent = $this->serializer->serialize($object, $format);
  }

  /*
   * Example $obj = $this->deserialize($json, '\App\DTO\UserRoleDTO', 'json');
   */

  public function deserialize($jsonContent, $class, $format = 'json', $complex = false) {
    if ($complex == true) {
      $object = $this->serializer->deserialize($jsonContent, $class, $format);
      $annotations = $this->getFlipAnotations($class);
      if (!empty($annotations)) {
        $data = (array) json_decode($jsonContent);
        foreach ($annotations as $relation_key => $relation_entity) {
          if (isset($data[$relation_key]) && !empty($data[$relation_key])) {
            $relationObject = array();
            foreach ($data[$relation_key] as $object_val) {
              $relationObject[] = $this->deserialize(json_encode((array) $object_val), (string) trim($relation_entity[0]), $format, true);
            }
            $setter = (string) "set" . ucfirst(trim($relation_key));
            $object->$setter($relationObject);
          }
        }
      }
      return $object;
    } else {
      return $this->serializer->deserialize($jsonContent, $class, $format);
    }
  }

  private function getFlipAnotations($class) {
    $annotationReader = new \Doctrine\Common\Annotations\AnnotationReader();
    $cachedReader = new \App\Cache\CachedReader(
      new \Doctrine\Common\Annotations\IndexedReader($annotationReader), new \Doctrine\Common\Cache\ArrayCache()
    );
    $reflectionClass = new \ReflectionClass($class);
    $annotations = $cachedReader->getClassFlipAnnotation($reflectionClass);
    return $annotations;
  }

  /**
   * Function render.
   *
   * This function render response of api.
   *
   * @return JSON
   *   This return json string response.
   */
  public function render($response) {
    $error = $response->getError();
    if (!empty($error)) {
      $errorDetails = $this->getErrorMsgByCode($error->getCode());
      if (isset($errorDetails['userMessage']) && !empty($errorDetails['userMessage'])) {
        $error->setMessage($errorDetails['userMessage']);
        $response->addError($error);
      }
    }
    if (!empty($response->getError())) {
      echo $this->serialize(array("errors" => $response->getError()));
    } else {
      echo $this->serialize($response->getResponse());
    }
  }

  /**
   * Function _http_response_code.
   *
   * This function is use to get error code.
   *
   * @return INT
   *   This return code of error in response.
   */
  function _http_response_code($code = NULL) {
    if ($code !== NULL) {
      switch ($code) {
        case 100: $text = 'Continue';
          break;
        case 101: $text = 'Switching Protocols';
          break;
        case 200: $text = 'OK';
          break;
        case 201: $text = 'Created';
          break;
        case 202: $text = 'Accepted';
          break;
        case 203: $text = 'Non-Authoritative Information';
          break;
        case 204: $text = 'No Content';
          break;
        case 205: $text = 'Reset Content';
          break;
        case 206: $text = 'Partial Content';
          break;
        case 300: $text = 'Multiple Choices';
          break;
        case 301: $text = 'Moved Permanently';
          break;
        case 302: $text = 'Moved Temporarily';
          break;
        case 303: $text = 'See Other';
          break;
        case 304: $text = 'Not Modified';
          break;
        case 305: $text = 'Use Proxy';
          break;
        case 400: $text = 'Bad Request';
          break;
        case 401: $text = 'Unauthorized';
          break;
        case 402: $text = 'Payment Required';
          break;
        case 403: $text = 'Forbidden';
          break;
        case 404: $text = 'Not Found';
          break;
        case 405: $text = 'Method Not Allowed';
          break;
        case 406: $text = 'Not Acceptable';
          break;
        case 407: $text = 'Proxy Authentication Required';
          break;
        case 408: $text = 'Request Time-out';
          break;
        case 409: $text = 'Conflict';
          break;
        case 410: $text = 'Gone';
          break;
        case 411: $text = 'Length Required';
          break;
        case 412: $text = 'Precondition Failed';
          break;
        case 413: $text = 'Request Entity Too Large';
          break;
        case 414: $text = 'Request-URI Too Large';
          break;
        case 415: $text = 'Unsupported Media Type';
          break;
        case 500: $text = 'Internal Server Error';
          break;
        case 501: $text = 'Not Implemented';
          break;
        case 502: $text = 'Bad Gateway';
          break;
        case 503: $text = 'Service Unavailable';
          break;
        case 504: $text = 'Gateway Time-out';
          break;
        case 505: $text = 'HTTP Version not supported';
          break;
        default:
          exit('Unknown http status code "' . htmlentities($code) . '"');
          break;
      }
      $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
      $code = $protocol . ' ' . $code . ' ' . $text;
    } else {
      $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
    }
    return $code;
  }

  /**
   * Function getErrorMsgByCode.
   *
   * This function is use to get error message by error code.
   *
   * @return Array
   *   This return Array in response.
   */
  public function getErrorMsgByCode($msgCodes) {
    $result = false;
    try {
      $errorMessageComponent = new ErrorMessageComponent;
      $result = $errorMessageComponent->errorMessageByCode($msgCodes);
    } catch (\Exception $e) {
      $result = false;
    }
    return $result;
  }

  /**
   * Function p.
   *
   * This function is use to print $value.
   *
   * @return print and die
   *   
   */
  public function p($value) {
    echo "<pre>";
    print_r($value);
    die;
  }

}
