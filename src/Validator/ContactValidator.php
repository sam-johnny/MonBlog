<?php
namespace App\Validator;

class ContactValidator extends AbstractValidator
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->validator->labels(array(
            'username' => "Le nom",
            'message' => 'Le message',
            'email' => "L'adresse email"
        ));
        $this->validator->rule('required', ['username', 'message', 'email']);
        $this->validator->rule('lengthBetween', ['username', 'message'], 6, 200);
        $this->validator->rule('email', 'email');
    }
}