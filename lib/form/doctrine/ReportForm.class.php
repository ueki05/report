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
    // これ要らないのか？
    // useFieldsとsetWidgetsの関係は？
    // useFieldsしてからsetWidgetsするとフォームから項目消える
    $this->useFields(array('target_date', 'user_id', 'body'));

    // ここが悪さしているけど、なんでかわかっていない
    //     $this->setWidgets(array(
    //       'target_date' => new sfWidgetFormDate(array(
    //         'format' => '%year% 年 %month% 月 %day%',
    //         'label' => '対象日',
    //       )),
    //       'user_id' => new sfWidgetFormDoctrineChoice(array(
    //         'label' => '入力者',
    //         'model' => 'User',
    //       )),
    //       'body' => new sfWidgetFormTextarea(array(
    //         'label' => '本文',
    //       ), array(
    //         'rows' => '40',
    //         'cols' => '70',
    //       )),
    //     ));

    $this->widgetSchema->setLabels(array(
      'target_date' =>  '対象日',
      'user_id'     =>  '入力者',
      'body'        =>  '本文',
    ));

    $this->setValidator('user_id', new sfValidatorDoctrineChoice(array(
      'model'  => 'User',
    )));
  }
}
