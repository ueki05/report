<table>
  <tbody>
    <tr>
      <th>Id:</th>
      <td><?php echo $report->getId() ?></td>
    </tr>
    <tr>
      <th>User:</th>
      <td><?php echo $report->getUserId() ?></td>
    </tr>
    <tr>
      <th>Body:</th>
      <td><?php echo $report->getBody() ?></td>
    </tr>
    <tr>
      <th>Is sent:</th>
      <td><?php echo $report->getIsSent() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $report->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $report->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('report/edit?id='.$report->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('report/index') ?>">List</a>
