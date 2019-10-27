<?php

class RegionService implements IServiceBase
{

    public function GetById($id)
    {
        $utilities = new Utilities();
        $listadoRegion = $this->GetList();
        $elementDecode = $utilities->searchProperty($listadoRegion, 'id', $id)[0];
        $element = New Region();
        $element->set($elementDecode);
        return $element;
    }

    public function GetList()
    {
        $utilities = new Utilities();
        $listadoRegion = array();

        if (isset($_COOKIE['region'])) {
            $listadoRegion = json_decode($_COOKIE['region'],false); 
        } else {
            setcookie("region", json_encode($listadoRegion), $utilities->GetCookieTime(), "/");
        }

        return $listadoRegion;
    }

    public function Add($entity)
    {
        $utilities = new Utilities();
        $listadoRegion = $this->GetList();

        $regionId = 1; 
        if (!empty($listadoRegion)) { 
            $lastCharacter = $utilities->getLastElement($listadoRegion); 
            $regionId =  $lastCharacter->id + 1; 
        }

        $entity->id = $regionId;

        array_push($listadoRegion, $entity); 

        setcookie("region", json_encode($listadoRegion), $utilities->GetCookieTime(), "/");
    }

    public function Update($id, $entity)
    {
        $utilities = new Utilities();      
        $listadoRegion = $this->GetList();
        $elementIndex = $utilities->getIndexElement($listadoRegion, 'id', $id); 

    

        $listadoRegion[$elementIndex] =  $entity; 

        setcookie("region", json_encode($listadoRegion), $utilities->GetCookieTime(), "/");
    }

    public function Delete($id)
    {
        $utilities = new Utilities();
        $listadoRegion = $this->GetList();
   

        $elementIndex = $utilities->getIndexElement($listadoRegion, 'id', $id); 
 
    
        unset($listadoRegion[$elementIndex]);

        $listadoRegion = array_values($listadoRegion);
        setcookie("region", json_encode($listadoRegion), $utilities->GetCookieTime(), "/");
    }
}
