
<?php
$term = get_term_by('slug', 'review-sections', 'ekwa-theme-resources-category');
$term_ID = $term->term_id;
$headerDesigns = get_installed_resources($term_ID);
if($headerDesigns){
    foreach($headerDesigns as $item){
        $installedHeaders[] = (int) $item['id'];
    }
    echo "<script>";
    echo 'var installedHeaders = '.json_encode($installedHeaders).';';
    echo "</script>";
}else{
    echo "<script>";
    echo 'var installedHeaders = [999999999999999999]';
    echo "</script>";
}

?>

<div class="ekwa-admin-page" data-url="<?php echo admin_url('admin-ajax.php');?>" data-type="success-stories" data-category="<?php echo $term_ID;?>" data-directory="sections/review-sections">
    
</div>
    <div class="card-header">
        <h1 class="ekwa_admin_heading">Review section templates</h1>
    </div>
    <div class="preloader">
        <div class="fa-2x">
            <i class="fas fa-sync fa-spin"></i>
        </div>
    </div>
    <div class="ekwa-admin-page-container">
            <div class="container-fluid" id="ekwa_headers">
                
                <div class="installed-items">
                    <?php
                    if($headerDesigns):
                    
                    ?>
                    <?php foreach($headerDesigns as $headerDesign):?>
                        <div id="item-<?php echo $headerDesign['post_id'];?>" class="row-header installed">
                                <img class="img-thumbnail" src="<?php echo $headerDesign['thumbnail'];?>" >
                            <div class="btn-wrapper">
                                <a class="btn btn-primary" href="<?php echo  admin_url( '/customize.php?autofocus[section]=headers' );?>"> <i class="fas fa-eye"></i> Preview </a>
                                <a class="btn btn-danger deleteItem" data-postid="<?php echo $headerDesign['post_id'];?>" data-id="<?php echo $headerDesign['id'];?>" href="javascript:;"><i class="fas fa-trash-alt"></i> Remove</a>
                            </div>
                        </div>
                    <?php endforeach;?> 	
                    
                    <?php endif;?>
                    
                </div>
                 <div id="headers_list">
                    
                </div>
                
                
                <!--pagination-->
                <div class="pagination-wrapper">
        
                    <div id="pagination-container">
            
                    </div>
                    <div class="total-posts-wrapper">
                       <span>Total: <label id="totalPosts"></label></span> 
                    </div>
    
                </div>
                <!--pgin-->
                
                
                
            </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel"> Are u  sure ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body del-modal-body">
        
        <button class="btn delete_confirmed btn-danger"><i class="far fa-check-circle"></i> Yes </button>
        <button class="btn btn-primary" data-dismiss="modal"><i class="far fa-times-circle"></i> No </button>
        
      </div>
    </div>
  </div>
</div>