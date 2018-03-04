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

    $this->reports = Doctrine_Core::getTable('Report')
      ->createQuery('r')
      ->innerJoin('r.User u')
      ->where('r.updated_at BETWEEN ? AND ?',
        array(date('Y-m-d 00:00:00', time()), date('Y-m-d 23:59:59', time())))
        ->execute();

    $this->users = Doctrine_Core::getTable('User')
      ->createQuery('u')
      ->execute();

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

    $report = new Report();
    $report->setTargetDate(date('Y-m-d'));

    $report = Doctrine_Core::getTable('Report')
      ->createQuery('r2')
      ->where('r2.user_id = ?', $loginUserId)
      ->orderBy('r2.updated_at DESC')
      ->fetchOne();

    $this->form = new ReportForm($report);
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
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ReportForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
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
    $this->form = new ReportForm($report);

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

      $this->redirect('report/edit?id='.$report->getId());
    }
  }
}
