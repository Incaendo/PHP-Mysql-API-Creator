<?php

namespace App\DAO;

use App\Model\<<entityName>>Model as <<entityName>>Model;

/**
 * @file
 * Class <<entityName>>DAO
 * This Is <<entityName>> DAO
 * @author <<AUTHOR>>
 */
class <<entityName>>Dao {

  private $em;

  public function __construct() {
    $this->em = \Slim\Registry::getEm();
  }

  public function get<<entityName>>ById($<<entityNameCamelCase>>Id) {
    return $this->em->getRepository('App\Model\<<entityName>>Model')->findById($<<entityNameCamelCase>>Id);
  }

  public function save<<entityName>>(<<entityName>>Model $<<entityNameCamelCase>>) {
    $dateTime = $this->util->getCurentDateTime();
    $user->setCteatedDate($dateTime);
    $user->setUpdatedDate($dateTime);
    $this->em->persist($<<entityNameCamelCase>>);
    $this->em->flush();
    return $<<entityNameCamelCase>>;
  }

  public function update<<entityName>>(<<entityName>>Model $<<entityNameCamelCase>>) {
    $dateTime = $this->util->getCurentDateTime();
    $user->setUpdatedDate($dateTime);
    $this->em->persist($<<entityNameCamelCase>>);
    $this->em->flush();
    return $<<entityNameCamelCase>>;
  }

}
