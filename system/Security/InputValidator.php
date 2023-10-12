<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Security;
use Luminova\Security\ValidatorInterface;
use Luminova\Functions\Functions;
class InputValidator implements ValidatorInterface{
    /**
     * @var array $errors validated errors messages
    */
    protected array $errors = [];

     /**
     * @var array $validationRules validation rules
    */
    protected array $validationRules = [];

    /**
     * @var array $errorMessages validation error messages
    */
    protected array $errorMessages = [];

    /**
     * Validate entries
     * @param array $input array input to validate it fields
     * @param array $rules Optional passed rules as array
     * @return boolean true if the rule passed else false
    */
    public function validateEntries(array $input, array $rules = []): bool
    {
        if(empty($rules) || $rules == []){
            $rules = $this->validationRules;
        }

        if(empty( $rules )){
            return true;
        }

        if(empty( $input )){
            return false;
        }
  

        $this->errors = [];
        foreach ($rules as $field => $rule) {
            $fieldValue = $input[$field] ?? null;

            if (is_callable($rule)) {
                if (!$rule($fieldValue)) {
                    $this->errors[$field][] = "Validation failed for $field.";
                }
            } else {
                $ruleParts = explode('|', $rule);
                foreach ($ruleParts as $rulePart) {
                    $ruleName = preg_replace("/\s*\([^)]*\)/", '', $rulePart);
           
                    if ($ruleName === 'required' && empty($fieldValue)) {
                        $this->errors[$field][] = $this->errorMessages[$field][$ruleName] ?? "The $field field is required.";
                        break;
                    }
                    elseif ($ruleName === 'match') {
                        $param = str_replace(['match(', ')'], '', $rulePart);
                        if (!preg_match('/' . $param . '/', $fieldValue)) {
                            $this->errors[$field][] = $this->errorMessages[$field][$ruleName] ?? "Validation failed for $field.";
                            break;
                        }
                    }elseif ($ruleName === 'equals') {
                        $matchWith = str_replace(['equals(', ')'], '', $rulePart);
                        if ($fieldValue !== $input[$matchWith]) {
                            $this->errors[$field][] = $this->errorMessages[$field][$ruleName] ?? "Validation failed for $field.";
                            break;
                        }
                    }elseif ($ruleName === 'fallback') {
                        $defaultValue = str_replace(['fallback(', ')'], '', $rulePart);
                        if (empty($fieldValue)) {
                            $defaultValue = "";
                        }else if(strtolower($defaultValue) == 'null'){
                            $defaultValue = null;
                        }
                        $input[$field] = $defaultValue;
                    } elseif (strpos($rulePart, ':') !== false) {
                        [$validationType, $param] = explode(':', $rulePart);

                        if (!$this->validateField($ruleName, $fieldValue, $validationType, $param)) {
                            $this->errors[$field][] = $this->errorMessages[$field][$ruleName] ?? "Validation failed for $field.";
                            break;
                        }
                    } else {
                        if (!$this->validateField($ruleName, $fieldValue, $rulePart)) {
                            $this->errors[$field][] = $this->errorMessages[$field][$ruleName] ?? "Validation failed for $field.";
                            break;
                        }
                    }
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Validate fields 
     * @param string $ruleName The name of the rule to validate
     * @param string $value The value to validate
     * @param string $rule The rule line
     * @param string $param additional validation parameters
     * @return boolean true if the rule passed else false
    */
    public function validateField(string $ruleName, string $value, string $rule, ?string $param = null): bool
    {
        
        switch ($ruleName) {
            case 'max_length':
                $max = (int) str_replace(['max_length(', ')'], '', $rule);
                return strlen($value) <= $max;
            case 'min_length':
                $min = (int) str_replace(['min_length(', ')'], '', $rule);
                return strlen($value) >= $min;
            case 'exact_length':
                $exact = (int) str_replace(['exact_length(', ')'], '', $rule);
                return strlen($value) == $exact;
            case 'integer':
                $isInteger = filter_var($value, FILTER_VALIDATE_INT) !== false; 
                $type = str_replace(['integer(', ')'], '', $rule);
                if($type === "positive"){
                    return $isInteger && (int)$value > 0;
                }elseif($type === "negative"){
                    return $isInteger && (int)$value < 0;
                }
                return $isInteger;
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            case 'alphanumeric':
                return preg_match("/[^A-Za-z0-9]/", $value) !== false;
            case 'alphabet':
                return preg_match("/^[A-Za-z]+$/", $value) !== false;
            case 'url':
                return filter_var($value, FILTER_VALIDATE_URL) !== false;
            case 'uuid':
                //$version = (int) str_replace(['uuid(', ')'], '', $rule);
                return Functions::is_uuid($value);
            case 'ip':
                $version = (int) str_replace(['ip(', ')'], '', $rule);
                return Functions::is_ip($value, $version);
            case 'decimal':
                return preg_match('/^-?\d+(\.\d+)?$/', $value) === 1;
            default:
                return true;
        }
    }

    /**
     * Gets validation error
     * @return array validation error message
    */
    public function getErrors(): array{
        return empty($this->errors) ? [] : ['errorMessage' => 'Validation errors.', 'errors' => $this->errors];
    }

    /**
     * Set rules array array with optional messages
     * @param array $rules validation rules
     * @param array $message optional pass response message for validation
     * @return self InputValidator instance 
    */
    public function setRules(array $rules, array $messages = []): self{
        $this->validationRules = $rules;
        if(!empty($messages)){
            $this->errorMessages = $messages;
        }
        return $this;
    }

   /**
     * Add single rule with optional message
     * @param string $field validation rule input field name
     * @param array $messages optional pass response message for rule validation
     * @return self InputValidator instance 
    */
    public function addRule(string $field, string $rules, array $messages = []): self{
        $this->validationRules[$field] = $rules;
        if(!empty($message)){
            $this->errorMessages[$field] = $messages;
        }
        return $this;
    }

    /**
     * Set array list rule messages
     * @param array $messages messages to set
     * @return self InputValidator instance 
    */
    public function setMessages(array $messages): self{
        $this->errorMessages = $messages;
        return $this;
    }

     /**
     * Set a single validation rule messages
     * @param string $field messages input field name
     * @param array $messages messages to set
     * @return self InputValidator instance 
    */
    public function addMessage(string $field, array $messages): self{
        $this->errorMessages[$field] = $messages;
        return $this;
    }
}
