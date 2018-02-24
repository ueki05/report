<h1>Reports List</h1>

<?php include_partial('form', array('form' => $form)) ?>

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
    <?php foreach ($reports as $report): ?>
    <tr>
      <td><a href="<?php echo url_for('report/show?id='.$report->getId()) ?>"><?php echo $report->getId() ?></a></td>
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
