<?php 
$align = $block['align'];
$block_id = $block['id'];
if( !empty($block['anchor']) ) {
   $block_id = $block['anchor'];
}
$className = 'working-hrs';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
$color = '#000';
if(get_field('color')){
    $color = get_field('color');
}

?>
<div id="<?php echo $block_id;?>" class="<?php echo $className." "; if($align){echo $align;}?>">
<?php  $working_hrs = get_theme_mod( 'working_hrs', null );  if($working_hrs): ?>
                    <div class="workin-hr-block">
                     
                            <?php foreach( $working_hrs as $working_hr ) : ?>
                            <div class="working-hrs-raw">
                                <div class="day"><?php echo $working_hr['day'];?>: </div>
                                <div class="time"><?php echo $working_hr['opening'];?>
                                    <?php if(($working_hr['opening'])):?> -
                                    <?php endif; ?>
                                    <?php 
                                    if($working_hr['closed']){
                                        echo 'Closed';
                                    }else{
                                        echo $working_hr['closing'];
                                    }
                                    if($working_hr['extra_text']){
                                        echo $working_hr['extra_text'];
                                    }
                                    
                                    ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                   
                    </div>
                    <?php endif;?>
</div>
<style>
    #<?php echo $block_id;?>.left .working-hrs-raw{
        justify-content: flex-start;
    }
    #<?php echo $block_id;?>.right .working-hrs-raw{
        justify-content: flex-end;
    }
    #<?php echo $block_id;?>.center .working-hrs-raw{
        justify-content: center;
    }
    .working-hrs-raw{
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }
    .working-hrs-raw .day{
        margin-right: 20px;
    }
    #<?php echo $block_id;?>{
        color: <?php echo $color;?>;
    }
</style>
