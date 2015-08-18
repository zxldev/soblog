<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class PasswordResets extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $token;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $this->validate(
            new Email(
                array(
                    'field'    => 'email',
                    'required' => true,
                )
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'password_resets';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PasswordResets[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PasswordResets
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
