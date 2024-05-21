<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,

        //Custom Validate
        \App\Validations\MemberValidation::class

    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $productInsertValidation=[
        'product_title' => [
          'label' => 'Title',
          'rules' => 'required'
        ],
        'product_description' => [
          'label' => 'Description',
          'rules' => 'required'
        ],
        'product_price' => [
          'label' => 'Price',
          'rules' => 'required'
        ],
        'product_show' => [
          'label' => ' Status',
          'rules' => 'required'
        ]
    ];

    public $strongPasswordValidation=[
      'name' => [
        'label' => 'User Name',
        'rules' => 'required|max_length[35]|alpha_numeric_punct'
      ],
      'email' => [
        'label' => 'Email',
        'rules' => 'required|valid_email|is_unique[member_ms.member_email]'
      ],
      'password' => [
        'label' => 'Password',
        'rules' => 'required|min_length[6]|max_length[35]|strongPassword[password]'
      ],
      'cpassword' => [
        'label' => 'Confirmation Password',
        'rules' => 'required|matches[password]'
      ],
      'phone' => [
        'label' => 'Phone',
        'rules' => 'required'
      ]
      ];

}
