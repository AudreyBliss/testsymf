<?php

namespace AppBundle\Network;

//nom du bundle + nom du dossier ds lequel est la classe

class  ServiceCurl 
//nom de classe
{
   /**
    * Service qui permet d'afficher sur une map un marqueur par rapport aux coordonnées
    *
    * @param string $adresse adresse postale dont on veut connaître les coordonnées GPS
    *
    * @return array
    *
    * @example curl_get('74, avenue Denfert Rochereau 75014 Paris')
    */




    public function curl_get($adresse)
    {   
        $defaults = [
            CURLOPT_URL => "http://api-adresse.data.gouv.fr/search/?q=$adresse&type=street",
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 4
        ];
        
        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        if( ! $result = curl_exec($ch))
        {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result; 

    }
}


