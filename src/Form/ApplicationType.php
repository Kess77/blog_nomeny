<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

/**
 * Permet de configurer les champs des formulaire
 * 
 */

class ApplicationType extends AbstractType{

    protected function getConfiguration($label,$placeholder, $options =[]){
        return array_merge([
            'label'=>$label,
            'attr'=>[
                'placeholder'=>$placeholder
            ]
            ],$options)
        ;

    }
}