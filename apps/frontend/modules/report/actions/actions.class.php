<?php

/**
 * report actions.
 *
 * @package    report
 * @subpackage report
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    // authを実装していないので、一旦user_idを2とする
    $loginUserId = 2;

    if (isset($_GET['target_date'])) {
      $targetDate = date('Ymd', strtotime($_GET['target_date']));
    } else {
      $targetDate = date('Ymd');
    }

    $this->targetDate = date('Y年m月d日', strtotime($targetDate));
    $this->prev = date('Ymd', strtotime($targetDate . ' - 1day'));
    if ($targetDate != date('Ymd', time())) {
      $this->next = date('Ymd', strtotime($targetDate . ' + 1day'));
    }

    $this->reports = Doctrine_Core::getTable('Report')->getReportsByTargetDate($targetDate);

    $this->users = Doctrine_Core::getTable('User')->getUsers();

    $showReports = array();

    foreach ($this->users as $user) {
      $showReports[$user->getId()]['user'] = $user;
    }

    foreach ($this->reports as $report) {
      foreach ($showReports as $showReport) {
        if ($report->getUserId() == $showReport['user']->getId()) {
          $showReports[$report->getUserId()]['report'] = $report;
        }
      }
    }
    $this->showReports = $showReports;

    $report = Doctrine_Core::getTable('Report')->getReportUserLatest($loginUserId);

    $this->form = new ReportForm();
    $this->form->setDefault('target_date', date('Y-m-d'));
    $this->form->setDefault('body', $report->getBody());
    $this->form->setDefault('user_id', $report->getUserId());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->report = Doctrine_Core::getTable('Report')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->report);
  }

  public function executeNew(sfWebRequest $request)
  {
    $report = new Report();
    $report->setTargetDate(date('Y-m-d'));

    $this->form = new ReportForm($report);

  }

  public function executeCreate(sfWebRequest $request)
  {
    $postData = $this->getRequest()->getParameterHolder()->getAll();
    $postTargetDate = sprintf('%s-%02s-%02s', $postData['report']['target_date']['year'], $postData['report']['target_date']['month'], $postData['report']['target_date']['day']);
    $latestUserReport = Doctrine_Core::getTable('Report')->getReportUserLatest($postData['report']['user_id']);

    $this->forward404Unless($request->isMethod(sfRequest::POST));

    // 当日のreportが既に登録済のときは、登録しない
    if ($postTargetDate != $latestUserReport['target_date']) {
      $this->form = new ReportForm();
      $this->processForm($request, $this->form);
      $this->setTemplate('new');
    } else {
      $this->form = new ReportForm();
      $this->getUser()->setFlash('notice', sprintf('Saving failed. The report has already saved.'));
      $this->redirect('report/index');
    }
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($report = Doctrine_Core::getTable('Report')->find(array($request->getParameter('id'))), sprintf('Object report does not exist (%s).', $request->getParameter('id')));
    $this->form = new ReportForm($report);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($report = Doctrine_Core::getTable('Report')->find(array($request->getParameter('id'))), sprintf('Object report does not exist (%s).', $request->getParameter('id')));

    $postReport = $_POST['report'];
    $postTargetDate = sprintf('%s-%02s-%02s', $postReport['target_date']['year'], $postReport['target_date']['month'], $postReport['target_date']['day']);

    // fetchOneしてレコードがあればupdate, なければcreateにする
    $record = Doctrine_Core::getTable('Report')
      ->createQuery('q')
      ->where('q.target_date = ?', $postTargetDate)
      ->andWhere('q.user_id = ?', $postReport['user_id'])
      ->fetchOne();

    // MEMO: 一旦登録できないので修正、ただどうすれば新規登録と更新を出し分けできるのかわからん
    // 新規登録したいときid invalidになる
    if ($record) {
      $this->form = new ReportForm($report);
    } else {
      $this->form = new ReportForm();
    }

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($report = Doctrine_Core::getTable('Report')->find(array($request->getParameter('id'))), sprintf('Object report does not exist (%s).', $request->getParameter('id')));
    $report->delete();

    $this->redirect('report/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    // ここでWarning、array_key_exists(): The first argument should be either a string or an integer
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $report = $form->save();
      $this->getUser()->setFlash('notice', sprintf('The report save succeeded.'));
      $this->redirect('report/edit?id='.$report->getId());
    }
  }
}
