<div id="content-left">
  <?php include_partial('form', array('form' => $form)) ?>
</div>

<div id="content-right">
  <table id="reports">
    <thead>
      <tr>
        <th>順位</th>
        <th>入力者</th>
        <th>登録時間</th>
        <th>送信</th>
        <th>内容</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 0 ?>
      <?php foreach ($reports as $report): ?>
      <?php $i++ ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $report->getUser()->getLastName() . "." . $report->getUser()->getFirstName() ?></td>
        <td><?php echo date_format(date_create($report->getUpdatedAt()), 'H:i:s') ?><?php echo link_to('修正', 'report_edit', array('id' => $report->getId())) ?></td>
        <td><?php echo $report->getIsSent() ?></td>
        <td><?php echo $report->getBody() ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<div>
