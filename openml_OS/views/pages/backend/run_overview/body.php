<div class="bs-docs-container topborder">
  <div class="container">
    <div class="col-sm-12">
      <h2>Run Overview</h2>
        <table class="table table-striped duplicatetable">
          <thead>
            <tr>
              <td></td>
              <td>Run id</td>
              <?php foreach( $this->inputs as $input ): ?>
                <td><?php echo $input; ?></td>
              <?php endforeach; ?>
              <td>Runs</td>
            </tr>
          </thead>
          <tbody>
            <?php foreach( $this->runs as $group ): $entrees = explode( ',', $group->runs ); ?>
              <?php for( $i = 0; $i < count($entrees); ++$i ): ?>
                <tr id="duplicate_run_<?php echo $entrees[$i]; ?>">
                  <td><input type="checkbox" data-run_id="<?php echo $entrees[$i]; ?>" data-in_group_nr="<?php echo $i; ?>" class="duplicate_checkbox" id="duplicate_checkbox_<?php echo $entrees[$i]; ?>" /></td>
                  <td><?php echo $entree; ?></td>
                  <?php foreach( $this->inputs as $input ): ?>
                    <td><?php if( property_exists ($group, $input ) ) { echo $group->$input; } ?></td>
                  <?php endforeach; ?>
                </tr>
              <?php endfor; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
    </div>
  </div>
</div>
