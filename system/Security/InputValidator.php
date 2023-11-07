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
        if (empty($rules)) {
            $rules = $this->validationRules;
        }
    
        if (empty( $rules ) || (empty($rules) && empty($input))) {
            return true;
        }

        $this->errors = [];
        foreach ($rules as $field => $rule) {
            $fieldValue = $input[$field] ?? null;
            $ruleParts = explode('|', $rule);
            foreach ($ruleParts as $rulePart) {
                $ruleName = preg_replace("/\s*\([^)]*\)/", '', $rulePart);
                switch ($ruleName) {
                    case 'none':
                        return true;

                    case 'required':
                        if (empty($fieldValue)) {
                            $this->addError($field, $ruleName);
                        }
                        break;
                    case 'callback':
                        $callback = str_replace(['callback(', ')'], '', $rulePart);
                        if (is_callable($callback) && !$callback($fieldValue, $field)) {
                            $this->addError($field, $ruleName);
                        }
                        break;
                    case 'match':
                        $param = str_replace(['match(', ')'], '', $rulePart);
                        if (!preg_match('/' . $param . '/', $fieldValue)) {
                            $this->addError($field, $ruleName);
                        }
                        break;

                    case 'equals':
                        $matchWith = str_replace(['equals(', ')'], '', $rulePart);
                        if ($fieldValue !== $input[$matchWith]) {
                            $this->addError($field, $ruleName);
                        }
                        break;

                    case 'in_array':
                        $matchWith = str_replace(['in_array(', ')'], '', $rulePart);
                        if (!empty($matchWith)) {
                            $matches = self::listToArray($matchWith);
                            if (!in_array($fieldValue, $matches)) {
                                $this->addError($field, $ruleName);
                            }
                        }
                        break;

                    case 'keys_exist':
                        $matchWith = str_replace(['keys_exist(', ')'], '', $rulePart);
                        if (!empty($matchWith)) {
                            $matches = self::listToArray($matchWith);
                            if (is_array($fieldValue)) {
                                $intersection = array_intersect($matches, $fieldValue);
                                $exist = count($intersection) === count($fieldValue);
                            } else {
                                $exist = self::listInArray($fieldValue, $matches);
                            }
                            if (!$exist) {
                                $this->addError($field, $ruleName);
                            }
                        }
                        break;

                    case 'fallback':
                        $defaultValue = str_replace(['fallback(', ')'], '', $rulePart);
                        if (empty($fieldValue)) {
                            $defaultValue = "";
                        } elseif (strtolower($defaultValue) == 'null') {
                            $defaultValue = null;
                        }
                        $input[$field] = $defaultValue;
                        break;

                    default:
                        if (!$this->validateField($ruleName, $fieldValue, $rulePart)) {
                            $this->addError($field, $ruleName);
                        }
                        break;
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
     * Convert string list to array 
     * 
     * @example listToArray('a,b,c') => ['a', 'b', 'c']
     * @example listToArray('"a","b","c"') => ['a', 'b', 'c']
     * 
     * @param string $list string list
     * @return array $matches
    */
    public static function listToArray(string $list): array {
        $matches = [];
    
        preg_match_all("/'([^']+)'/", $list, $matches);
    
        if (!empty($matches[1])) {
            return $matches[1];
        }
    
        preg_match_all('/(\w+)/', $list, $matches);
    
        if (!empty($matches[1])) {
            return $matches[1];
        }
        return [];
    }

    /**
     * Check if string list exist in array 
     * If any of the list doesn't exist in array it will return false
     * First it will have to convert the list to array using
     * listToArray()
     * 
     * @param string $list string list
     * @param array $map Array to map list to
     * 
     * @return bool exist or not
    */
    public static function listInArray(string $list, array $map): bool 
    {
        $array = self::listToArray($list);
        foreach ($array as $item) {
            if (!in_array($item, $map)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Gets validation error
     * @return array validation error message
    */
    public function getErrors(): array
    {
        return $this->errors??[];
    }

    /**
     * Get validation error messages
     * @param string $field messages input field name
     * @return string Error message
    */
    public function getError(string $field): string
    {
        return $this->errors[$field][0]??'';
    }

    /**
     * Add validation error message
     * 
     * @param string $field input field name
     * @param string $ruleName Rule name
     * @param string $message Error message
     * 
     * @return void 
    */
    public function addError($field, $ruleName, $message = 'Validation failed for %s.'): void
    {
        $message = sprintf($message, $field);
        $this->errors[$field][] = $this->errorMessages[$field][$ruleName] ?? $message;
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
