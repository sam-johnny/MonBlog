<?php
namespace App\Validator;

class CommentValidator extends AbstractValidator
{

    /**
     * Paramètre des régles à valider avec Validator
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->validator->labels(array(
            'username' => "Le nom",
            'content' => 'Le contenu',
            'email' => 'L\'adresse mail'
        ));
        $this->validator->rule('required', ['content']);
        $this->validator->rule('lengthBetween', ['username', 'content'], 4, 200);
        $this->validator->rule('email', 'email');
    }
}