<?php
namespace App\Controller\Pages;

use \Exception;

use \App\Controller\Exception\HttpException;

use \App\View\View;

use \App\Utils\DataValidator;

use \App\Model\Entity\Establishment\Establishment as EntityEstablishment;
use \App\Model\Entity\Establishment\EstablishmentInfo as EntityEstablishmentInfo;
use \App\Model\Entity\Establishment\EstablishmentAddress as EntityEstablishmentAddress;
use \App\Model\Log\LogManager;

class Establishment extends Page{
    const LOG_FILE_SET = 'pageControllerLog';
    
    public static function getEstablishmentPage($id) { 
        try {
            return 
                parent::getPage(
                    'Dionise - Estabelecimento', 
                     self::getEstablishment($id), 
                    'Default'
                );
        }catch(HttpException $e){
            LogManager::log($e->getHttpCode(), $e->getSeverity(), $e->getMessage(), self::LOG_FILE_SET);
            return Error::getHttpErrorPage($e->getHttpCode());;
        }
     
    }

    //pode ser melhorado com assincronicidade
    private static function getEstablishment($id)
    {
        $establishmentArray = EntityEstablishment::getById($id);
        
        if(!DataValidator::isValidObjectArray($establishmentArray, EntityEstablishment::class, 0, 1)) 
            throw new HttpException(__METHOD__ . ' fail -> Invalid Argument: ' . print_r($establishmentArray, true), 500, 4);
        if(sizeof($establishmentArray) == 0)                                                          
            throw new HttpException(__METHOD__ . ' fail -> Establishment with ID = ' . $id . 'Not Found', 404, 1);
                
        return implode('', array_map(
            fn($establishment) => View::render('pages/Establishment/EstablishmentPage', [
                'name'           => $establishment->getName(),
                'description'    => $establishment->getDescription(),
                'introImageLink' => $establishment->getIntroImageLink(),
                'address'        => self::getAddress($id),
                'infos'          => self::getInfos($id)
            ]),
            $establishmentArray
        )); 
    }

    private static function getInfos($establishmentId)
    {   
        $establishmentInfoArray = EntityEstablishmentInfo::getEstablishmentInfos($establishmentId);

        if(!DataValidator::isValidObjectArray($establishmentInfoArray, EntityEstablishmentInfo::class)) 
            throw new HttpException(__METHOD__ . ' fail -> Invalid Argument: ' . print_r($establishmentInfoArray, true), 500, 4);
        if(sizeof($establishmentInfoArray) == 0)                                                          
            throw new HttpException(__METHOD__ . ' fail -> Establishment with ID = ' . $establishmentId . ' without Info', 404, 1);

        return implode('', array_map(
            fn($info) => View::render('pages/Establishment/Info', [
                'sequence' => $info->getSequence(),
                'title'    => $info->getTitle(),
                'text'     => $info->getText()
            ]),
            $establishmentInfoArray
        )); 
    }

    private static function getAddress($establishmentId)
    {
        $establishmentAddressArray = EntityEstablishmentAddress::getByEstablishmentId($establishmentId);

        if(!DataValidator::isValidObjectArray($establishmentAddressArray, EntityEstablishmentAddress::class, 0, 1)) 
            throw new HttpException(__METHOD__ . ' fail -> Invalid Argument: ' . print_r($establishmentAddressArray, true), 500, 4);
        if(sizeof($establishmentAddressArray) == 0)                                                          
            throw new HttpException(__METHOD__ . ' fail -> Establishment with ID = ' . $establishmentId . ' without Address', 404, 1);

        $establishmentAddress = $establishmentAddressArray[0];
        return $establishmentAddress->getAddress()      . ', ' 
             . $establishmentAddress->getNumber()       . ' - ' 
             . $establishmentAddress->getNeighborhood() . ', ' 
             . $establishmentAddress->getCity()         . ' - ' 
             . $establishmentAddress->getState()        . ', ' 
             . substr_replace($establishmentAddress->getCep(), '-', 5, 0);
    }

}