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
use Luminova\Functions\IPAddress;

class InputValidator implements ValidatorInterface
{
    /**
     * @var array $errors validated errors messages
    */
    protected array $errors = [];

     /**
     * @var array $validationRules validation rules
    */
    public array $validationRules = [];

    /**
     * @var array $errorMessages validation error messages
    */
    public array $errorMessages = [];

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
                $ruleParam = str_replace([$ruleName . '(', ')'], '', $rulePart);
                switch ($ruleName) {
                    case 'none':
                        return true;

                    case 'required':
                        if (self::isEmpty($fieldValue)) {
                            $this->addError($field, $ruleName);
                        }
                        break;
                    case 'callback':
                        if (is_callable($ruleParam) && !$ruleParam($fieldValue, $field)) {
                            $this->addError($field, $ruleName);
                        }
                        break;
                    case 'match':
                        if (!preg_match('/' . $ruleParam . '/', $fieldValue)) {
                            $this->addError($field, $ruleName);
                        }
                        break;

                    case 'equals':
                        if ($fieldValue !== $input[$ruleParam]) {
                            $this->addError($field, $ruleName);
                        }
                        break;

                    case 'in_array':
                        if (!empty($ruleParam)) {
                            $matches = self::listToArray($ruleParam);
                            if (!in_array($fieldValue, $matches)) {
                                $this->addError($field, $ruleName);
                            }
                        }
                        break;

                    case 'keys_exist':
                        if (!empty($ruleParam)) {
                            $matches = self::listToArray($ruleParam);
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
                        $defaultValue = $ruleParam;
                        if (self::isEmpty($fieldValue)) {
                            $defaultValue = "";
                        } elseif (strtolower($ruleParam) == 'null') {
                            $defaultValue = null;
                        }
                        $input[$field] = $defaultValue;
                        break;

                    default:
                        if (!$this->validateField($ruleName, $fieldValue, $rulePart, $ruleParam)) {
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
    public function validateField(string $ruleName, string $value, string $rule, mixed $param = null): bool
    {
        return match ($ruleName) {
            'max_length' => strlen($value) <= (int) $param,
            'min_length' => strlen($value) >= (int) $param,
            'exact_length' => strlen($value) == (int) $param,
            'integer' => match ($param) {
                'positive' => filter_var($value, FILTER_VALIDATE_INT) !== false && (int)$value > 0,
                'negative' => filter_var($value, FILTER_VALIDATE_INT) !== false && (int)$value < 0,
                default => filter_var($value, FILTER_VALIDATE_INT) !== false,
            },
            'email' => filter_var($value, FILTER_VALIDATE_EMAIL) !== false,
            'alphanumeric' => preg_match("/[^A-Za-z0-9]/", $value) !== false,
            'alphabet' => preg_match("/^[A-Za-z]+$/", $value) !== false,
            'url' => filter_var($value, FILTER_VALIDATE_URL) !== false,
            'uuid' => Functions::is_uuid($value), //$version = (int) $param;
            'ip' => IPAddress::isValid($value, (int) $param),
            'phone' => Functions::is_phone($value),
            'decimal' => preg_match('/^-?\d+(\.\d+)?$/', $value) === 1,
            'binary' => ctype_print($value) && !preg_match('/[^\x20-\x7E\t\r\n]/', $value),
            'hexadecimal' => ctype_xdigit($value),
            'array' => is_array(json_decode($value, true)),
            'json' => (json_decode($value) && json_last_error() == JSON_ERROR_NONE),
            'path' => match ($param) {
                'true' => is_string($value) && is_readable($value),
                default => is_string($value) && preg_match("#^[a-zA-Z]:[\\\/]{1,2}#", $value)
            },
            'scheme' => strpos($value, rtrim($param, '://')) === 0,
            default => true,
        };
    }

    /**
     * Check if input is empty 
     * 
     * @param mixed $value input value 
     * 
     * @return bool
    */
    private static function isEmpty(mixed $value) {
        return $value === null || $value === '' || strlen($value) < 1;
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
     * Get validation error messages
     * @param int $indexField field index
     * @param int $indexErrors error index
     * 
     * @return string Error message
    */
    public function getErrorLine(int $indexField = 0, int $indexErrors = 0): string
    {
        $errors = $this->errors;
        // Get the keys of the provided indices
        $fieldKey = array_keys($errors)[$indexField] ?? null;
        $errorKey = array_keys($errors[$fieldKey])[$indexErrors] ?? null;

        // Retrieve the error message based on the indices
        $errorMessage = $errors[$fieldKey][$errorKey] ?? '';

        // Remove the parent key from the error array
        unset($errors[$fieldKey]);

        return $errorMessage;
    }

     /**
     * Get validation error messages
     * @param int $indexField field index
     * @param int $indexErrors error index
     * 
     * @deprecated This method will be removed in a future release use getErrorLine instead
     * @return string Error message
    */
    public function getErrorByIndices(int $indexField = 0, int $indexErrors = 0){
        return $this->getErrorLine($indexField, $indexErrors);
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
