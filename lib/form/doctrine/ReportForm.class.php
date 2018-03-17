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

    // 入力者の項目にユーザー名が表示されるよう設定
    $users = Doctrine_Core::getTable('User')
      ->createQuery('u')
      ->execute();

    $userNames = array();
    foreach ($users as $user) {
      $userNames[$user->getId()] = sprintf('%s.%s', $user->getLastName(), $user->getFirstName());
    }

    $this->widgetSchema['user_id']  =  new sfWidgetFormChoice(array(
      'choices' =>  $userNames,
    ));

    // 本文のtextareaのサイズ設定
    $this->widgetSchema['body'] = new sfWidgetFormTextarea(
      array(),
      array('rows' => 40, 'cols' => 60)
    );

    // formの各項目のラベルをカスタマイズ
    $this->widgetSchema->setLabels(array(
      'target_date' =>  '対象日',
      'user_id'     =>  '入力者',
      'body'        =>  '本文',
    ));
  }
}
