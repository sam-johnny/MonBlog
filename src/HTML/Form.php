<?php

namespace App\HTML;

/**
 * Class Form
 * Permet de générer un formulaire rapidement et simplement
 */
class Form
{
    private $data;
    private $errors;

    /**
     * @param $data
     * @param array $errors
     */
    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors = $errors;
    }

    /**
     * Génère le code html de la balise <input>
     *
     * @param string $key
     * @param string $label
     * @return string
     */
    public function input(string $key, string $label): string
    {
        $value = $this->getValue($key);
        $type = 'text';
        if ($key === 'password') {
            $type = 'password';
        }
        if ($key === 'email') {
            $type = 'email';
        }
        return <<<HTML
    <div class="form-group mb-3">
        <label for="field{$key}">{$label}</label>
        <input type="{$type}" id="field{$key}" class="{$this->getInputClass($key)} " name="{$key}" value="$value" required>
        {$this->getErrorFeedback($key)}
    </div>
HTML;
    }

    /**
     * Génère le code html de la balise <input> en valeur de la date du jour
     *
     * @param string $key
     * @param string $label
     * @return string
     */
    public function inputUpdateDate(string $key, string $label): string
    {
        $value = date('Y-m-d H:i:s');
        return <<<HTML
    <div class="form-group mb-3">
        <label for="field{$key}">{$label}</label>
        <input type="text" id="field{$key}" class="{$this->getInputClass($key)} " name="{$key}" value="$value" required>
        {$this->getErrorFeedback($key)}
    </div>
HTML;
    }

    /**
     * Génère le code html de la balise <input> pour les commentaires
     *
     * @param string $key
     * @param string $label
     * @param string|null $value
     * @return string
     */
    public function inputComment(string $key, string $label, ?string $value): string
    {
        $type = 'text';

        return <<<HTML
    <div class="form-group mb-3">
        <label for="field{$key}">{$label}</label>
        <input type="{$type}" id="field{$key}" class="{$this->getInputClass($key)} " name="{$key}" value="$value" required>
        {$this->getErrorFeedback($key)}
    </div>
HTML;

    }

    /**
     * Génère le code html de la balise <textarea>
     *
     * @param string $key
     * @param string $label
     * @return string
     */
    public function textarea(string $key, string $label): string
    {

        $value = $this->getValue($key);
        return <<<HTML
    <div class="form-group mb-3">
        <label for="field{$key}">{$label}</label>
        <textarea type="text" id="field{$key}" class="{$this->getInputClass($key)}" rows="5" name="{$key}" required>{$value}</textarea>
        {$this->getErrorFeedback($key)}
    </div>
HTML;
    }

    /**
     * Génère le code html de la balise <select>
     *
     * @param string $key
     * @param string $label
     * @param array $options
     * @return string
     */
    public function select(string $key, string $label, array $options = []): string
    {
        $optionsHTML = [];
        $value = $this->getValue($key);
        foreach ($options as $k => $v) {
            $selected = in_array($k, $value) ? " selected" : "";
            $optionsHTML[] = "<option value=\"$k\"$selected>$v</option>";
        }
        $optionsHTML = implode('', $optionsHTML);

        return <<<HTML
    <div class="form-group mb-3">
        <label for="field{$key}">{$label}</label>
        <select id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}[]" required multiple>{$optionsHTML}</select>
        {$this->getErrorFeedback($key)}
    </div>
HTML;
    }

    /**
     * Génère les gets automatiquement pour la valeur du champ
     *
     * @param string $key
     * @return mixed|string|null
     */
    private function getValue(string $key)
    {
        if (is_array($this->data)) {
            return $this->data[$key] ?? null;
        }
        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $value = $this->data->$method();
        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    /**
     * Génère 'is-invalid' si l'utilisateur ne respecte pas les règles mises dans les classes de validator
     *
     * @param string $key
     * @return string
     */
    private function getInputClass(string $key): string
    {
        $inputClass = 'form-control';
        if (isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }
        return $inputClass;
    }

    /**
     * Génère 'invalid-feedback' si l'utilisateur ne respecte pas les règles mises dans les classes de validator
     *
     * @param string $key
     * @return string
     */
    private function getErrorFeedback(string $key): string
    {
        if (isset($this->errors[$key])) {
            if (is_array($this->errors[$key])) {
                $error = implode('<br>', $this->errors[$key]);
            } else {
                $error = $this->errors[$key];
            }
            return '<div class="invalid-feedback">' . $error . '</div>';
        }
        return '';
    }

}