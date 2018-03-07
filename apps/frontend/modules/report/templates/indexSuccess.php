<div id="content-left">
  <?php include_partial('form', array('form' => $form)) ?>
</div>

<div id="content-right">
<p><?php echo $targetDate . '分' ?> <?php echo link_to('<前日', 'report/index', array('query_string' => 'target_date=' . $prev)) ?> <?php echo isset($next) ? link_to('翌日>', 'report/index', array('query_string' => 'target_date=' . $next)) : "" ?></p>
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
      <?php foreach ($showReports as $showReport): ?>
      <?php $i++ ?>
      <tr>
        <td><?php echo isset($showReport['report']) ? $i : "未" ?></td>
        <td><?php echo $showReport['user']->getLastName() . "." . $showReport['user']->getFirstName() ?></td>
        <td><?php echo isset($showReport['report']) ? date('H:i:s', strtotime($showReport['report']->getUpdatedAt())) : "" ?> <?php echo link_to('編集', 'report_edit', array('id' => $showReport['report']->getId())) ?></td>
        <td><?php echo isset($showReport['report']) && $showReport['report']->getIsSent() == 1 ? "済" : "未" ?></td>
        <td><?php echo isset($showReport['report']) ? $showReport['report']->getBody() : "" ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<div>
