<?php


namespace app\core;


/**
 * Class Model
 * @package app\core
 */
abstract class Model
{
    // Rules for validation
    /**
     * If data must be required
     */
    public const RULE_REQUIRED = 'required';
    /**
     * If data must be email
     */
    public const RULE_EMAIL = 'email';
    /**
     * If data must be more than min value
     *
     * Must be used in array with
     * the second named element 'min'
     * to define the minimum value
     */
    public const RULE_MIN = 'min';
    /**
     * If data must be less than max value
     *
     * Must be used in array with
     * the second named element 'max'
     * to define the maximum value
     */
    public const RULE_MAX = 'max';
    /**
     * If data must be the same as another data
     *
     * Must be used in array with
     * the second named element 'match' to
     * define the element it must matches with
     */
    public const RULE_MATCH = 'match';
    /**
     * If data must be unique for
     * specified database model class
     *
     * Must be used in array with
     * the second named element 'class' to
     * define the class in what
     * data must be unique
     *
     * May contain the third named element 'attribute'
     * if must be unique with another attribute
     */
    public const RULE_UNIQUE = 'unique';

    /**
     * Fulfilled each parameter of Model with
     * the given data if exists
     * @param $data
     */
    public function loadData($data): void
    {
        // Foreach data if parameter of Model exists
        // full this parameter
        foreach ($data as $key => $value) {
            // If property of Model exists full it
            if (property_exists($this, $key)) {
                // Full property of the given key
                // by given value
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Validate data with the rules;
     * if invalid create an error
     * @return bool
     */
    public function validate(): bool
    {
        // Validate each attribute with the rules
        foreach ($this->rules() as $attribute => $rules) {
            // Set $value as an attribute's one from the rule
            $value = $this->{$attribute};
            // Validate attribute by checking it with each  rule
            foreach ($rules as $rule) {
                // Rule is a string, but some rules must contain value
                // to work, for example: max => 255
                //
                // Set the ruleName as a rule if string
                $ruleName = $rule;
                // Set the ruleName as a first element
                // of rule array if it is an array
                if (is_array($ruleName)) {
                    $ruleName = $rule[0];
                }
                // Validation for different rules
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    // Get label of field that must be the same with current
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    // Get classname of given rule
                    $className = $rule['class'];
                    // Get attribute that is specified in rule
                    $uniqueAttribute = $rule['attribute'] ?? $attribute;
                    // Get table name of given class
                    $tableName = $className::tableName();
                    // Prepare statement in what select all records
                    // with same values of specified attributes
                    $statement = Application::$app->db->prepare(
                        "SELECT * FROM $tableName WHERE $uniqueAttribute = :attr"
                    );
                    // Bind value to statement
                    $statement->bindValue(":attr", $value);
                    // Execute statement
                    $statement->execute();
                    // Get record if exists
                    $record = $statement->fetchObject();
                    // If has record add error
                    if ($record) {
                        // Add error where field is attribute's label
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, [
                            'field' => $this->getLabel($attribute)
                        ]);
                    }
                }
            }
        }
        // Return true if no errors in errors array
        // else return false
        return empty($this->errors);
    }

    /**
     * Get label for the given attribute
     * @param $attribute
     * @return mixed
     */
    public function getLabel($attribute)
    {
        // Return a label from labels or
        // attribute name if not exists
        return $this->labels()[$attribute] ?? $attribute;
    }

    /**
     * Array that contains all labels for
     * every data element
     * @return array
     */
    public function labels(): array
    {
        // By default it is empty
        return [];
    }

    /**
     * The array containing all errors
     * @var array
     */
    public array $errors = [];

    /**
     * Add the error message to errors list
     * with specified params if exist
     * @param string $attribute
     * @param string $message
     * @param array $params
     */
    public function addError(string $attribute, string $message, array $params = []): void
    {
        // Check for params and add it to message if necessary
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        // Add message to errors array of the given attribute
        $this->errors[$attribute][] = $message;
    }

    /**
     * Add the error message of the given rule
     * to errors list with the params if exist
     * @param string $attribute
     * @param string $rule
     * @param array $params
     */
    private function addErrorForRule(string $attribute, string $rule, array $params = []): void
    {
        // Get message from errorMessages list
        $message = $this->errorMessages()[$rule] ?? '';
        // Add error to errors list
        $this->addError($attribute, $message, $params);
    }

    /**
     * Error messages for rules
     * @return string[]
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This must be a valid email address',
            self::RULE_MIN => 'Min length of this must be {min}',
            self::RULE_MAX => 'Max length of this must be {max}',
            self::RULE_MATCH => 'This field must be same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
        ];
    }

    /**
     * Check if attribute has an error
     * @param $attribute
     * @return false|mixed
     */
    public function hasError($attribute)
    {
        // Get the error from errors list of false
        return $this->errors[$attribute] ?? false;
    }

    /**
     * Get first error of attribute from errors list
     * @param $attribute
     * @return false|mixed
     */
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }

    /**
     * Rules that validate the given data
     * @return array
     */
    abstract public function rules(): array;
}