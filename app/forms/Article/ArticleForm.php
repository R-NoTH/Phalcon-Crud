<?php

namespace App\Forms\Article;

use CategoriesArticles;
use Phalcon\Forms\Form;
//form  element input
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
//validarions
use Phalcon\Validation;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Uniqueness;

class ArticleForm extends Form
{
  public function initialize($entity = null, array $options = [])
  {
    if (isset($options['edit'])) {
      $id = new Hidden('id',[
        'required' => true,
      ]);
      $this->add($id);
    }


    /*
    // Name Article field
    */
    $nameArticle = new Text(
      'nameArticle',
      [
        'class' => 'form-control',
        'placeholder' => 'Nombre del Articulo',
      ]
    );
    // nameArticle validation
    $nameArticle->addValidator(
      new PresenceOf(
        [
          'message' => 'El Nombre es requerido',
        ]
      )
    );
    /*
    // Description Article field
    */
    $descriptionArticle = new TextArea(
      'descriptionArticle',
      [
        'class' => 'form-control',
        'placeholder' => 'Description del Articulo',
      ]
    );
    // nameArticle validation
    $descriptionArticle->addValidator(
      new PresenceOf(
        [
          'message' => 'La Descripcion es requerido',
        ]
      )
    );

    $type = new Select(
      'id_type',
      CategoriesArticles::find(),
      [
        'using'      => ['id', 'name'],
        'useEmpty'   => true,
        'emptyText'  => 'Elija una Categoria',
        'emptyValue' => '',
        'class' => 'form-control',
      ]
    );
    $type->setLabel('Type');
    /*
    //submit button
    */
    $submit = new Submit(
      'Enviar',
      [
        'class' => 'btn btn-primary',
      ]
    );

    $this->add($nameArticle);
    $this->add($descriptionArticle);
    $this->add($type);
    $this->add($submit);
  }
}
