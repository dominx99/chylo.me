<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator {

    protected $errors;

    protected $fieldMap = [
        'from' => 'Email',
        'subject' => 'Temat',
        'body' => 'Treść'
    ];

    public function validate($request, $rules){

        foreach($rules as $field => $rule){
            try {
                if(array_key_exists($field, $this->fieldMap)){
                    $rule->setName(ucfirst($this->fieldMap[$field]))->assert($request->getParam($field));
                } else {
                    $rule->setName(ucfirst($field))->assert($request->getParam($field));
                }
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        $_SESSION['errors'] = $this->errors;

        return $this;

    }

    public function failed(){
        return !empty($this->errors);
    }

}
