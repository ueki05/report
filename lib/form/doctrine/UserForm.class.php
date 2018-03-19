<?php

/**
 * User form.
 *
 * @package    report
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserForm extends BaseUserForm
{
  public function configure()
  {
    $this->useFields(array('first_name', 'last_name', 'email'));

    $this->setValidator('first_name', new sfValidatorString(array(
      'min_length' => 1,
      'max_length' => 50,
    ),
    array(
      'min_length' => 'Please post a longer message',
      'max_length' => 'Please be less verbose',
    )));

    $this->setValidator('last_name', new sfValidatorString(array(
      'min_length' => 1,
      'max_length' => 50,
    ),
    array(
      'min_length' => 'Please post a longer message',
      'max_length' => 'Please be less verbose',
    )));

    $this->setValidator('email', new sfValidatorEmail());
  }
}
