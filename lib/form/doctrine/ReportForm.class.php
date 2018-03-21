<?php

/**
 * Report form.
 *
 * @package    report
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReportForm extends BaseReportForm
{
  public function configure()
  {
    // ユーザーに入力してもら項目だけ表示するようにする
    $this->useFields(array('target_date', 'user_id', 'body'));

    // target_dateのカスタマイズ
    $years = range(2015, date('Y'));
    $this->widgetSchema['target_date'] = new sfWidgetFormDate(array(
      'format'  =>  '%year%年%month%月%day%日',
      'years' =>  array_combine($years, $years),
    ));
    $this->validatorSchema['target_date'] = new sfValidatorDate(array(
      'max' =>  date('Y-m-d'),
    ));

    // user_idのカスタマイズ
    $users = Doctrine_Core::getTable('User')
      ->createQuery('u')
      ->execute();

    $userNames = array();
    $userIds = array();
    foreach ($users as $user) {
      $userNames[$user->getId()] = sprintf('%s.%s', $user->getLastName(), $user->getFirstName());
      $userIds[] = $user->getId();
    }

    $this->widgetSchema['user_id']  =  new sfWidgetFormChoice(array(
      'choices' =>  $userNames,
    ));

    $this->setValidator('user_id', new sfValidatorChoice(array(
      'choices' => $userIds,
    )));

    // bodyのカスタマイズ
    $this->widgetSchema['body'] = new sfWidgetFormTextarea(
      array(),
      array('rows' => 40, 'cols' => 60)
    );
    $this->validatorSchema['body'] = new sfValidatorString(array(
      'min_length' => 10,
      'max_length' => 255,
    ), array(
      'required'   => '入力が必須です',
      'min_length' => '本文が短すぎます。最低10文字入力してください。',
      'max_length' => '本文が長すぎます。最大255文字です。',
    ));

    // formの各項目のラベルをカスタマイズ
    $this->widgetSchema->setLabels(array(
      'target_date' =>  '対象日',
      'user_id'     =>  '入力者',
      'body'        =>  '本文',
    ));
  }
}
