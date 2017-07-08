<?php

namespace App\Component;

use App\Model\<<entityName>>Model as <<entityName>>Model;
use App\DAO\<<entityName>>Dao as <<entityName>>DAO;
use App\DTO\<<entityName>>Dto as <<entityName>>DTO;
use App\HTTP\<<entityName>>Sro as <<entityName>>SRO;
use App\Exception\<<entityName>>Exception as <<entityName>>Exception;
use App\Translators\<<entityName>>Translator as <<entityName>>Translators;
use App\Validator\<<entityName>>Validator as <<entityName>>Validators;

/**
 * @file
 * Class <<entityName>>Component
 * @author <<AUTHOR>>
 */
class <<entityName>>Component {
  private $logger;
  private $translators;
  private $validator;

  public function __construct() {
    $this->logger = \Slim\Registry::getLogger();
    $this->translators = new <<entityName>>Translators();
    $this->validator = new <<entityName>>Validators();
  }
  
  <<apiComponentList>>
}
