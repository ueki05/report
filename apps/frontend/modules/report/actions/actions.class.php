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
    $this->reports = Doctrine_Core::getTable('Report')
      ->createQuery('a')
      ->execute();
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
