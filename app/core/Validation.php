<?php

namespace app\core;

class Validation
{
    public const METHOD_REQUIREMENTS = [
        'login'    => [
            'login'    => 'required|min:5|max:20',
            'password' => 'required|min:6|max:30|uncorrected',
        ],
        'register' => [
            'name'            => 'required|min:2|max:50|unique',
            'login'           => 'required|min:5|max:20|different:password',
            'password'        => 'required|min:6|max:30|different:secret_answer',
            'password_repeat' => 'required|same:password',
            'secret_answer'   => 'required|min:2|max:100',
        ],
        'forgot'   => [
            'login'         => 'required|min:5|max:20',
            'secret_answer' => 'required|min:2|max:100|invalidanswer',
        ],
        'reset'    => [
            'password'        => 'required|min:6|max:30',
            'repeat_password' => 'required|same:password',
        ],
    ];

    /**
     * @var array
     */
    public array $errors = [];

    /**
     * @var array
     */
    public array $old = [];

    /**
     * @param string $method
     * @param array  $params
     *
     * @return bool
     */
    public function validate(string $method, array $params): bool
    {
        $this->resetState();

        foreach (self::METHOD_REQUIREMENTS[$method] as $field => $rules) {
            $this->processField($field, $rules, $params);
        }

        Session::setItem('errors', $this->errors);
        Session::setItem('old', $this->old);
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public static function getErrors(): array
    {
        $errors = Session::getItem('errors');
        return $errors ?? [];
    }

    /**
     * @return array
     */
    public static function getOld(): array
    {
        $old = Session::getItem('old');
        return $old ?? [];
    }

    /**
     * @return void
     */
    public static function clear(): void
    {
        Session::deleteItem('errors');
        Session::deleteItem('old');
    }

    /**
     * @param string $field
     * @param string $rules
     * @param array  $params
     *
     * @return void
     */
    private function processField(string $field, string $rules, array $params): void
    {
        $old              = Session::getItem('old') ?? [];
        $value            = $params[$field] ?? ($old[$field] ?? null);
        $rulesArray       = explode('|', $rules);
        $hasRequiredError = $this->applyRequiredRules($field, $value, $rulesArray, $params);

        if (!$hasRequiredError) {
            $this->applyOtherRules($field, $value, $rulesArray, $params);
        }

        if (!str_contains($field, 'password')) {
            $this->old[$field] = $value;
        }
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $rules
     * @param array  $params
     *
     * @return bool
     */
    private function applyRequiredRules(string $field, mixed $value, array $rules, array $params): bool
    {
        $hasRequiredError = false;
        foreach ($rules as $rule) {
            if (str_starts_with($rule, 'required')) {
                $this->applyRule($field, $value, $rule, $params);
                if (is_null($value) || $value === '') {
                    $hasRequiredError = true;
                }
            }
        }
        return $hasRequiredError;
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $rules
     * @param array  $params
     *
     * @return void
     */
    private function applyOtherRules(string $field, mixed $value, array $rules, array $params): void
    {
        foreach ($rules as $rule) {
            if (!str_starts_with($rule, 'required')) {
                $this->applyRule($field, $value, $rule, $params);
            }
        }
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param string $rule
     * @param array  $params
     *
     * @return void
     */
    private function applyRule(string $field, mixed $value, string $rule, array $params): void
    {
        if (str_contains($rule, ':')) {
            [$type, $arg] = explode(':', $rule, 2);
        } else {
            $type = $rule;
            $arg  = null;
        }
        $method = $type . 'Rule';
        if (method_exists($this, $method)) {
            $this->$method($field, $value, $arg, $params);
        }
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return void
     */
    private function requiredRule(string $field, mixed $value): void
    {
        if (is_null($value) || $value === '') {
            $this->errors[$field][] = "$field обовзякове";
        }
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return void
     */
    private function uncorrectedRule(string $field, mixed $value): void
    {
        $userModel = new \app\models\UserModel();
        $user      = $userModel->getByLogin($_POST['login']);
        if (!$user || !password_verify($value, $user['password'])) {
            $this->errors[$field][] = "Неправильний логін або пароль";
        }
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @return void
     */
    private function invalidanswerRule(string $field, mixed $value): void
    {
        $userModel = new \app\models\UserModel();
        $user      = $userModel->getByLogin($_POST['login']);
        if (!$user || !password_verify($value, $user['secret_answer'])) {
            $this->errors[$field][] = "Неправильний логін або секретна відповідь";
        }
    }

    /**
     * @param string $field
     *
     * @return void
     */
    private function uniqueRule(string $field): void
    {
        $userModel = new \app\models\UserModel();
        $user      = $userModel->getByLogin($_POST['login']);
        if ($userModel->getByLogin($user['login'])) {
            $this->errors[$field][] = "Цей логін вже зайнятий";
        }
    }

    /**
     * @param string      $field
     * @param mixed       $value
     * @param string|null $arg
     *
     * @return void
     */
    private function minRule(string $field, mixed $value, ?string $arg): void
    {
        if (strlen($value) < $arg) {
            $this->errors[$field][] = "$field повинно бути не менше $arg символів";
        }
    }

    /**
     * @param string      $field
     * @param mixed       $value
     * @param string|null $arg
     *
     * @return void
     */
    private function maxRule(string $field, mixed $value, ?string $arg): void
    {
        if (strlen($value) > $arg) {
            $this->errors[$field][] = "$field повинно бути більше $arg символів";
        }
    }

    /**
     * @param string      $field
     * @param mixed       $value
     * @param string|null $arg
     * @param array       $params
     *
     * @return void
     */
    private function sameRule(string $field, mixed $value, ?string $arg, array $params): void
    {
        if (!isset($params[$arg]) || $value !== $params[$arg]) {
            $this->errors[$field][] = "$field повинен відповідати $arg";
        }
    }

    /**
     * @param string      $field
     * @param mixed       $value
     * @param string|null $arg
     * @param array       $params
     *
     * @return void
     */
    private function differentRule(string $field, mixed $value, ?string $arg, array $params): void
    {
        if (isset($params[$arg]) && $value === $params[$arg]) {
            $this->errors[$field][] = "$field не може співпадати з $arg";
        }
    }

    /**
     * @return void
     */
    private function resetState(): void
    {
        $this->errors = [];
        $this->old    = [];
    }
}