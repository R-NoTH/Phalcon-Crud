<?php

namespace App\Forms;

use Phalcon\Forms\Form;
//form  element input
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
//validarions
use Phalcon\Validation;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Uniqueness;



class RegisterForm extends Form
{
  public function initialize()
  {
    // **
    //form name field
    // **
    $name = new Text(
      'name',
      [
        'maxlength' => 30,
        'class' => 'form-control',
        'placeholder' => 'Ingresa tu nombre completo',
      ]
    );
    // name validation
    $name->addValidator(
      new PresenceOf(
        [
          'message' => 'El Nombre es requerido',
        ]
      )
    );

    // **
    //form email field.
    // **
    $email = new Text(
      'email',
      [
        'class' => 'form-control',
        'placeholder' => 'ingresa tu correo electronico'
      ]
    );
    // email validation
    // $email->addValidator([
    //     new PresenceOf(['message' => 'El e-mail es requerido']),
    //     new Email(['message' => 'El e-mail no es valido'])

    //   ]);
    $email->addValidators([
      new PresenceOf(['message' => 'El e-mail es requerido']),
      new Email(['message' => 'El e-mail no es valido']),
      // new Uniqueness(['message' => 'El e-mail debe ser unico'])
    //   new Uniqueness(
    //     [
    //         'message' => 'Another user with same email already exists',
    //         'cancelOnFail' => true,
    //     ]
    // )
    ]);


    // **
    // Password field 
    // **
    $password = new Password(
      'password',
      [
        'class' => 'form-control',
        'placeholder' => '*************'
      ]
    );
    // validation password
    $password->addValidators(
      [

        new PresenceOf(
          ['message' => 'La Password es requerida']
        ),
        new StringLength(
          [
            "min" => 6,
            "messageMinimum" => "La Password debe contener 6 caracteres minimo"
          ]
        ),
        new Confirmation(
          [
            "with" => 'password_confirm',
            "message" => "la contraseña no coincide con la confirmación "
          ]
        )
      ]
    );

    $password_confirm = new Password(
      'password_confirm',
      [
        'class' => 'form-control',
        'placeholder' => '*************'
      ]
    );
    $password_confirm->addValidator(
      new PresenceOf(
        [
          'message' => 'La Password es requerida',
        ]
      )
    );
    // **
    //form submit button..
    // **
    $submit = new Submit(
      'Enviar',
      [
        'class' => 'btn btn-primary',
      ]
    );

    $this->add($name);
    $this->add($email);
    $this->add($password);
    $this->add($password_confirm);

    $this->add($submit);
  }
}
