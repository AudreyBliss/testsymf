<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     */

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/testpage/index.html.twig', [
         'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
         'var_test' => 'Hello world'


        ]);
    }


    /**
     * @Route("/annuaire", name="annuaire")
     */

    public function annuaireAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/annuaire/annuaire.html.twig', [
         'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
         'annuaire' => $this -> getData()

        ]);
    }

     /**
     * @Route("/coordonnees/{id}", name="coordonnees")
     */
    public function coordonneesAction(Request $request, $id)
    {
       /*var_dump($this->getData()[$id]);die;*/
        $personne = $this-> getData()[$id];
        $adresse = str_replace(' ', '+', $personne['adresse']);
       /* $suggestion = json_decode($this -> curl_get($adresse),true);*/
        
       //pour le service
       $curl = $this->get('AppBundle\Network\ServiceCurl');//creation de l'objet (service actif)
        //pour l'utiliser $curl->curl_get
        $suggestion = json_decode($curl->curl_get($adresse),true);


        $gps = $suggestion['features'][0]['geometry']['coordinates']; 
        

        // replace this example code with whatever you need
        return $this->render('@App/annuaire/coordonnees.html.twig', [
         'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
         'annuaire' => $this -> getData()[$id],
         'latitude' => $gps[1],
         'longitude' => $gps[0]
        ]);
    }

    
    protected function getData(){
    $data = [
        
            ['nom'=>'Orwell', 'prenom'=>'Georges', 'telephone'=>'0000065', 'mail'=>'go@free.com', 'adresse'=>'93 rue Orfila 75020 Paris'],
            ['nom'=>'Jackman', 'prenom'=>'Hugh', 'telephone'=>'0000066', 'mail'=>'hj@free.com', 'adresse'=>'74 rue Denfert-Rochereau 750014 Paris'],
            ['nom'=>'Xavier', 'prenom'=>'Charles', 'telephone'=>'0000067', 'mail'=>'cx@free.com', 'adresse'=>'70 avenue de la revolution 75008 Paris'],
            ['nom'=>'Banner', 'prenom'=>'Bruce', 'telephone'=>'0000068', 'mail'=>'bb@free.com', 'adresse'=>'85 rue de la liberté 75001 Paris']

            ];
    
            return $data;
    }




/////////////////////////////////////////////////////////////////////////////////EVENTS///////////////////////////////////////////////////////////////////////////////////
    /**
     * @Route("/events", name="events")
     */

   /* public function eventAction(Request $request)// fonction pour afficher les evenements un par un
    {
        // replace this example code with whatever you need
        return $this->render('@App/event/events.html.twig', [
         'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
         //'events' => 'events'
         'events' => $this -> getEvents()
         
        ]);
    }*/

    public function eventAction(Request $request)// fonction pour afficher tout les evenements
    {
       $curl = $this -> get('AppBundle\Network\ServiceCurl');

       $events = $this -> getEvents();
       $gpsEvents = [];
       
       foreach($events as $e) {
           $adresse = str_replace(' ', '+', $e['adresse']);
           $suggestions = json_decode($curl->curl_get($adresse),true);
           $gps = $suggestions['features'][0]['geometry']['coordinates'];
           $e['latitude'] = $gps[1];
           $e['longitude'] = $gps[0];
           $gpsEvents[] = $e;
       } 
       
       return $this->render('@App/event/events.html.twig', [
        'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        'events' => $gpsEvents
    ]);
    
}



    protected function getEvents(){
        $events = [
            
                ['nom'=>'Nouvelle année', 'date'=>'01/01/2019', 'adresse'=>'Place du Trocadéro 75016 Paris'],
                ['nom'=>'Mon anniversaire', 'date'=>'15/05/2019','adresse'=>'Place de la Bastille 75011 Paris'],
                ['nom'=>'Cinéma en plein air', 'date'=>'20/09/2018', 'adresse'=>'70 rue de la Liberté 75008 Paris'],
                ['nom'=>'Feux d\'artifices', 'date'=>'05/11/2018', 'adresse'=>'70 avenue de la Révolution 75008 Paris']
    
                ];
        
                return $events;
        }
    

    /**
     * @Route("/eventdetails/{id}", name="eventdetails")
     */
    
    public function eventsdetailsAction(Request $request, $id)
    {
        
         $events = $this-> getEvents()[$id];
         $adresse = str_replace(' ', '+', $events['adresse']);
         $suggestion = json_decode($this -> curl_get($adresse),true);
         


        $gps = $suggestion['features'][0]['geometry']['coordinates']; 
        

        // replace this example code with whatever you need
        return $this->render('@App/event/eventdetails.html.twig', [
         'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
         'events' => $this -> getEvents()[$id],
         'latitude' => $gps[1],
         'longitude' => $gps[0]
        ]);
    }

   /* protected function curl_get($adresse)
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

    }*/

}


    
