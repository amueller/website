<oml:impact-progress xmlns:oml="http://openml.org/openml">
    <?php foreach($results as $res){ ?>
        <oml:progresspart>
            <oml:impact><?php echo $res['impact']; ?></oml:impact>
            <oml:reuse_reach><?php echo $res['reuse_reach']; ?></oml:reuse_reach>
            <oml:recursive_impact><?php echo $res['recursive_impact']; ?></oml:recursive_impact>
            <oml:date><?php echo $res['date']; ?></oml:date>
        </oml:progresspart>
    <?php }?>
</oml:impact-progress>