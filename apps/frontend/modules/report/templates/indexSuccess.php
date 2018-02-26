<div id="content-left">
  <?php include_partial('form', array('form' => $form)) ?>
</div>

<div id="content-rignt">
  <table>
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
      <?php foreach ($users as $user): ?>
      <?php $i++ ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $user->getLastName() . "." . $user->getFirstName() ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th>User</th>
        <th>Body</th>
        <th>Is sent</th>
        <th>Created at</th>
        <th>Updated at</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 0; ?>
      <?php foreach ($reports as $report): ?>
      <?php   $i++ ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $report->getUserId() ?></td>
        <td><?php echo $report->getBody() ?></td>
        <td><?php echo $report->getIsSent() ?></td>
        <td><?php echo $report->getCreatedAt() ?></td>
        <td><?php echo $report->getUpdatedAt() ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="<?php echo url_for('report/new') ?>">New</a>
<div>
