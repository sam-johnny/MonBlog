<?php
namespace App\Validator;

use Valitron\Validator;

abstract class AbstractValidator
{
    protected $data;
    protected $validator;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validator = new Validator($data);
    }

    /**
     * Validation des règles
     *
     * @return bool
     */
    public function validate (): bool
    {
        return $this->validator->validate();
    }

    /**
     * Retour des erreurs
     *
     * @return array
     */
    public function errors (): array
    {
        return $this->validator->errors();
    }
}