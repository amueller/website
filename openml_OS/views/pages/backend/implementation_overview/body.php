<div class="bs-docs-container topborder">
  <div class="container">
    <div class="col-sm-12">
      <h2>Run Overview</h2>
        <table class="table table-striped duplicatetable">
          <thead>
            <tr>
              <td></td>
              <?php foreach( $this->inputs as $input ): ?>
                <td><?php echo $input; ?></td>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach( $this->implementations as $implementation ): ?>
              
                <tr id="implementations_row_<?php echo $implementation->id; ?>">
                  <td>
                    <?php if($implementation->runs == false): ?>
                    <i class="fa fa-fw fa-times" onclick="if(confirm('Are you sure you want to delete implementation <?php echo $implementation->id; ?> (<?php echo $implementation->fullName; ?>)? This can not be undone. ')) deleteImplementation( <?php echo $implementation->id; ?>, true );"></i>
                    <?php endif; ?>
                  </td>
                  <?php foreach( $this->inputs as $input ): ?>
                    <td><?php if( property_exists ($implementation, $input ) ) { echo $implementation->$input; } ?></td>
                  <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    </div>
  </div>
</div>
