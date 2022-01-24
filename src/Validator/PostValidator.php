<?php
namespace App\Validator;

use App\Table\PostTable;

class PostValidator extends AbstractValidator
{

    /**
     * Paramètre des régles à valider avec Validator
     *
     * @param array $data
     * @param PostTable $table
     * @param int|null $postID
     * @param array $categories
     */
    public function __construct(array $data, PostTable $table, ?int $postID = null, array $categories)
    {
        parent::__construct($data);
        $this->validator->labels(array(
            'title' => 'Ce titre',
            'chapo' => 'Ce chapô',
            'slug' => 'Ce slug',
        ));
        $this->validator->rule('required', ['title', 'slug', 'chapo']);
        $this->validator->rule('lengthBetween', ['title', 'slug'], 3, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule('subset', 'categories_ids', array_keys($categories));
        $this->validator->rule(function ($field, $value) use ($table,$postID){
            return !$table->exists($field, $value, $postID);
        }, ['slug', 'title'], ' est déjà utilisé');
    }
}