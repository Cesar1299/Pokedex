<?php

class CharacterService implements IServiceBase
{

    public function GetById($id)
    {
        $utilities = new Utilities();
        $listadoPokemon = $this->GetList();
        $elementDecode = $utilities->searchProperty($listadoPokemon, 'id', $id)[0];
        $element = New Character();
        $element->set($elementDecode);
        return $element;
    }

    public function GetList()
    {
        $utilities = new Utilities();
        $listadoPokemon = array();

        if (isset($_COOKIE['pokemon'])) {
            $listadoPokemon = json_decode($_COOKIE['pokemon'],false); 
        } else {
            setcookie("pokemon", json_encode($listadoPokemon), $utilities->GetCookieTime(), "/");
        }

        return $listadoPokemon;
    }

    public function Add($entity)
    {
        $utilities = new Utilities();
        $listadoPokemon = $this->GetList();

        $characterId = 1; //El Id del pokemon que vamos a crear

        if (!empty($listadoPokemon)) { //validamos si ya hay pokemon creado
            $lastCharacter = $utilities->getLastElement($listadoPokemon); //Obtenemos el ultimo elemento del listado de pokemon  
            $characterId =  $lastCharacter->id + 1; //como ya existen pokemones el id del nuevo heroe debe ser el id el ultimo + 1
        }

        $entity->id = $characterId;
        $entity->profilePhoto = "";

        if ($_FILES['profilePhoto']) {

            $typeReplace = str_replace("image/", "", $_FILES["profilePhoto"]["type"]);
            $type =  $_FILES["profilePhoto"]["type"];
            $size =  $_FILES["profilePhoto"]["size"];
            $name = 'img/' . $characterId . '.' . $typeReplace;

            $sucess = $utilities->uploadImage("../Pokemon/img", $name, $_FILES['profilePhoto']['tmp_name'], $type, $size);

            if ($sucess) {
                $entity->profilePhoto = $name;
            }
        }

        array_push($listadoPokemon, $entity);

        setcookie("pokemon", json_encode($listadoPokemon), $utilities->GetCookieTime(), "/");
    }

    public function Update($id, $entity)
    {
        $utilities = new Utilities();
        $element = $this->GetById($id);
        $listadoPokemon = $this->GetList();

        $elementIndex = $utilities->getIndexElement($listadoPokemon, 'id', $id); 
        if ($_FILES['profilePhoto']) {

            if ($_FILES['profilePhoto']['error'] == 4) {
                $entity->profilePhoto = $element->profilePhoto;
            } else {
                $typeReplace = str_replace("image/", "", $_FILES["profilePhoto"]["type"]);
                $type =  $_FILES["profilePhoto"]["type"];
                $size =  $_FILES["profilePhoto"]["size"];
                $name = 'img/' . $id . '.' . $typeReplace;

                $sucess = $utilities->uploadImage("../Pokemon/img", $name, $_FILES['profilePhoto']['tmp_name'], $type, $size);

                if ($sucess) {
                    $entity->profilePhoto = $name;
                }
            }
        }

        $listadoPokemon[$elementIndex] =  $entity; 

        setcookie("pokemon", json_encode($listadoPokemon), $utilities->GetCookieTime(), "/");
    }

    public function Delete($id)
    {
        $utilities = new Utilities();
        $listadoPokemon = $this->GetList();
      

        $elementIndex = $utilities->getIndexElement($listadoPokemon, 'id', $id); 
 
    
        unset($listadoPokemon[$elementIndex]);

        $listadoPokemon = array_values($listadoPokemon);
        setcookie("pokemon", json_encode($listadoPokemon), $utilities->GetCookieTime(), "/");
    }
}
