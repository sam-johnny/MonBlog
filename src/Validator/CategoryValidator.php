<?php
namespace App\Validator;

use App\Model\Manager\CategoryManager;

class CategoryValidator extends AbstractValidator
{

    /**
     * Paramètre des régles à valider avec Validator
     *
     * @param array $data
     * @param CategoryManager $table
     * @param int|null $categoryID
     */
    public function __construct(array $data, CategoryManager $table, ?int $categoryID = null)
    {
        parent::__construct($data);
        $this->validator->labels(array(
            'name' => 'Ce titre',
            'slug' => 'Ce slug',
            'content' => 'Ce contenu'
        ));
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function ($field, $value) use ($table,$categoryID){
            return !$table->exists($field, $value, $categoryID);
        }, ['slug', 'name'], ' est déjà utilisé');
    }
}