<?php
namespace Application\Models;
use Application\Core\Model;
use RuntimeException;
use Rakit\Validation\Validator;

class User extends Model {

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $gender;
    public $password_hash;
    public $birth_date;
    public $avatar_path;
    protected static $table = 'users';

    private const VALIDATION_RULES = [
        'register' => [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date:Y-m-d',
            'password' => 'required|min:8|regex:/(?=.*\d)(?=.*[A-ZА-Я])/',
            'password_confirmation' => 'required|same:password'
        ],
        'login' => [
            'email' => 'required|email',
            'password' => 'required',
        ]
    ];

    public function __construct($data = [])
    {
        parent::__construct();
        $this->fill($data);
    }

    public function fill($data)
    {
        foreach ($data as $key => $value) {
            if (!property_exists(User::class, $key)) {
                throw new RuntimeException("No such field in user class: $key");
            }
            $this->$key = $value;
        }
    }

    /**
     * Метод сохраняет вносит запись о пользователе в бд с данными из текущего экземпляра класса или из переданного массива $data
     *
     * @param array $data default = []
     * @return void
     */
    public function save($data = [])
    {
        $this->db->insert(self::$table, !empty($data) ? $data : $this->getDataArray());
    }

    /**
     * Метод возвращает из бд записи о пользователях по полям fields и с условиями для where
     *
     * @param string $fields default = '*'
     * @param array $whereConditions default = []
     * @return void
     */
    public function get($fields = '*', $whereConditions = [])
    {
        return $this->db->select(self::$table, $fields, $whereConditions);
    }

    public function update($id = null, $data = [])
    {
        $data = $data ?? $this->getDataArray();
        unset($data['id']);
        $this->db->update(self::$table, $data, ['id' => $id ?? $this->id]);
    }

    public function getDataArray()
    {
        return [
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'email'         => $this->email,
            'birth_date'    => $this->birth_date,
            'gender'        => $this->gender,
            'avatar_path'   => $this->avatar_path,
            'password_hash' => $this->password_hash,
        ];
    }

    public static function sanitizeData($data)
    {
        $sanitizedData = [];
        if (!empty($data['first_name']))
            $sanitizedData['first_name'] = filter_var($data['first_name'], FILTER_SANITIZE_STRING);
        if (!empty($data['last_name']))
            $sanitizedData['last_name'] = filter_var($data['last_name'], FILTER_SANITIZE_STRING);
        if (!empty($data['email']))
            $sanitizedData['email'] = strtolower(filter_var($data['email'], FILTER_SANITIZE_EMAIL));
        if (!empty($data['birth_date']))
            $sanitizedData['birth_date'] = filter_var($data['birth_date'], FILTER_SANITIZE_STRING);
        if (!empty($data['gender']))
            $sanitizedData['gender'] = filter_var($data['gender'], FILTER_SANITIZE_STRING);
        if (!empty($data['avatar_path']))
            $sanitizedData['avatar_path'] = filter_var($data['avatar_path'], FILTER_SANITIZE_URL);
        if (!empty($data['password']))
            $sanitizedData['password'] = $data['password'];
        if (!empty($data['password_confirmation']))
            $sanitizedData['password_confirmation'] = $data['password_confirmation'];
        if (!empty($data['password_hash']))
            $sanitizedData['password_hash'] = $data['password_hash'];

        return $sanitizedData;
    }

    public static function validateData($data, $operation = 'login')
    {
        if (isset(self::VALIDATION_RULES[$operation])) {
            $rules = self::VALIDATION_RULES[$operation];
        } else {
            throw new RuntimeException('Operation type unknown');
        }

        $validator = new Validator([
            'required' => __('validation.required'),
            'email' => __('validation.email'),
            'date' => __('validation.date'),
            'min' => __('validation.min'),
            'same' => __('validation.same'),
            'regex' => __('validation.regex_password')
        ]);

        $validation = $validator->make($data, $rules);

        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors()->toArray();
            $errors = array_map(function ($e) {
                return array_values($e)[0];
            }, $errors);
            return ['success' => false, 'errors' => $errors];
        } else {
            return ['success' => true, 'errors' => []];
        }     
    }
}