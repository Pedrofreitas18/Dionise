<?php
namespace App\Controller\Pages;

use \App\View\View;
use \App\Model\Entity\Establishment\Establishment as EntityEstablishment;
use \App\Model\Entity\Establishment\EstablishmentInfo as EntityEstablishmentInfo;
use \App\Model\Entity\Establishment\EstablishmentAddress as EntityEstablishmentAddress;

class Establishment extends Page{
    //pode ser melhorado com assincronicidade
    public static function getEstablishment($id){
        $obEstablishment = EntityEstablishment::getById($id);

        $content =  View::render('pages/Establishment/establishment', [
            //'id'             => $obEstablishment->id,
            'name'           => $obEstablishment->name,
            'description'    => $obEstablishment->description,
            'introImageLink' => $obEstablishment->introImageLink,
            'address'        => self::getAddress($id),
            'infos'          => self::getInfos($id)
        ]);

        return parent::getPage('Dionise - Estabelecimento', $content);
    }

    private static function getInfos($establishmentId)
    {
        $content = '';
        $itens = EntityEstablishmentInfo::getEstablishmentInfos($establishmentId);

        foreach ($itens as &$item) {
            $content .=  View::render('pages/Establishment/info', [
                'id'       => $item->id,
                'sequence' => $item->sequence,
                'title'    => $item->title,
                'text'     => $item->text
            ]);
        }

        return $content;
    }

    private static function getAddress($establishmentId){
        $establishmentAddress = EntityEstablishmentAddress::getByEstablishmentId($establishmentId);

        return $establishmentAddress->address      . ', ' 
             . $establishmentAddress->number       . ' - ' 
             . $establishmentAddress->neighborhood . ', ' 
             . $establishmentAddress->city         . ' - ' 
             . $establishmentAddress->state        . ', ' 
             
             . substr_replace($establishmentAddress->cep, '-', 5, 0);
    }
}