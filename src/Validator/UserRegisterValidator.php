<?php
namespace App\Validator;

use App\Model\Manager\UserManager;

class UserRegisterValidator extends AbstractValidator
{

    /**
     * Paramètre des régles à valider avec Validator
     *
     * @param array $data
     * @param UserManager $table
     * @param int|null $userID
     */
    public function __construct(array $data, UserManager $table, ?int $userID = null)
    {
        parent::__construct($data);
        $this->validator->labels(array(
            'username' => "Ce nom d'utilisateur",
            'password' => 'Ce mot de passe',
            'email' => 'Cette adresse mail'
        ));
        $this->validator->rule('required', ['username', 'password', 'email']);
        $this->validator->rule('lengthBetween', ['name', 'password'], 6, 200);
        $this->validator->rule('email', 'email');
        $this->validator->rule(function ($field, $value) use ($table,$userID){
             return !$table->exists($field, $value, $userID);
        }, ['username', 'email'], ' est déjà utilisé');
    }
}