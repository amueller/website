      <h2><?php echo $table_name; ?></h2>
      <table class="table table-striped data_overview_table_<?php echo $counter; ?>">
        <thead>
          <tr>
            <?php foreach( $columns as $key ): ?>
              <td><?php echo $key; ?></td>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
