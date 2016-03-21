<oml:downvotes xmlns:oml="http://openml.org/openml">
  <?php foreach( $downvotes as $downvote ): ?>
  <oml:downvote>
    <oml:user_id><?php echo $downvote->user_id; ?></oml:user_id>
    <oml:knowledge_type><?php echo $downvote->knowledge_type; ?></oml:knowledge_type>
    <oml:knowledge_id><?php echo $downvote->knowledge_id; ?></oml:knowledge_id>
    <oml:reason><?php echo $downvote->reason_given; ?></oml:reason>
  </oml:downvote>
  <?php endforeach; ?>
</oml:downvotes>

