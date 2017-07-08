<?php

namespace App\Translators;

use App\DTO\<<entityName>>Dto as <<entityName>>DTO;
use App\HTTP\<<entityName>>Sro as <<entityName>>SRO;
use App\Model\<<entityName>>Model as <<entityName>>Model;

/**
 * @file
 * Class <<entityName>>Translators
 * This class is used for translators function.
 * @author <<AUTHOR>>
 */
class <<entityName>>Translator {  

  /**
   * Function populate<<entityName>>DTOFromModel.
   * This function is used to populate <<entityName>> DTO from model with Role DTO.
   * @author <<AUTHOR>>
   */
  public function populate<<entityName>>DTOFromModel(<<entityName>>Model $<<entityNameCamelCase>>Model) {
    $<<entityNameCamelCase>>DTO = new <<entityName>>DTO;
    <<populateDTOFromModelFieldList>>
    return $<<entityNameCamelCase>>DTO;
  }
  
  /**
   * Function populate<<entityName>>ModelFromDTO.
   * @author <<AUTHOR>>
   */
  public function populate<<entityName>>ModelFromDTO(<<entityName>>DTO $<<entityNameCamelCase>>DTO) {
    $<<entityNameCamelCase>>Model = new <<entityName>>Model;
    <<populateModelFromDTOFieldList>>
    return $<<entityNameCamelCase>>Model;
  }

  /**
   * Function populate<<entityName>>RoleSROFromDTO.
   * This function is used to populate <<entityName>> Roles SRO from DTO with Role DTO.
   * @author <<AUTHOR>>
   */
  public function populate<<entityName>>SROFromDTO(<<entityName>>DTO $<<entityNameCamelCase>>DTO) {
    $<<entityNameCamelCase>>SRO = new <<entityName>>SRO;
    <<populateSROFromDTOFieldList>>
    return $<<entityNameCamelCase>>SRO;
  }

  /**
   * Function populateCreate<<entityName>>DTOFromSRO.
   * This function is used to populate create <<entityNameCamelCase>> DTO from SRO.
   * @author <<AUTHOR>>
   */
  public function populate<<entityName>>DTOFromSRO(<<entityName>>SRO $<<entityNameCamelCase>>SRO) {
    $<<entityNameCamelCase>>DTO = new <<entityName>>DTO;
    <<populateDTOFromSROFieldList>>
    return $<<entityNameCamelCase>>DTO;
  }
 
}
