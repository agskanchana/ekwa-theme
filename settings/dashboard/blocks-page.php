
<?php
if(class_exists('ACF') ):

$term = get_term_by('slug', 'blocks', 'ekwa-theme-resources-category');
$term_ID = $term->term_id;
$headerDesigns = get_installed_resources($term_ID);
//var_dump($headerDesigns);
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
//var_dump($headerDesigns);
?>

<script>
    var installedBlocks = <?php echo json_encode($headerDesigns); ?>;
    console.log(installedBlocks);
    /*
    installedBlocks.forEach((element, index, array) => {
        if (element["id"] == 201) {
           elementIndex = index;
        }
    });
    console.log(installedBlocks[elementIndex].id);*/
    
    var BlocksLibrary = true;
    var SITEURL = "<?php echo get_option( 'siteurl' )."/wp-admin/admin.php?page=ekwa-theme-options-blocks";?>";
    <?php
    if(isset($_GET['block_type'])){
        echo "var blockType = '". $_GET['block_type']."'";
    }else{
        ?>
          var blockType = 'headers';
        <?php
    }
    
    ?>
</script>
<style>
    .btn-group-right{
    /*float: right;*/
}
</style>
<div class="ekwa-admin-page" data-url="<?php echo admin_url('admin-ajax.php');?>" data-type="blocks" data-category="<?php echo $term_ID;?>" data-directory="theme-blocks">
    
</div>
    <div class="card-header">
        <h1 class="ekwa_admin_heading">Ekwa Blocks Library </h1>
        <select id="select-block-type" class="custom-select">
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'headers'){echo 'selected';}}?> value="headers">header</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'footers'){echo 'selected';}}?> value="footers">footer</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'content'){echo 'selected';}}?> value="content">Content</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'hero'){echo 'selected';}}?> value="hero">hero</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'service-boxes'){echo 'selected';}}?> value="service-boxes">Services</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'headline'){echo 'selected';}}?> value="headline">Headline</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'button'){echo 'selected';}}?> value="button">Button</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'call-to-action'){echo 'selected';}}?> value="call-to-action">call to action</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'team'){echo 'selected';}}?> value="team">team</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'contact'){echo 'selected';}}?> value="contact">contact</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'pricing'){echo 'selected';}}?> value="pricing">pricing</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'logos'){echo 'selected';}}?> value="logos">logos</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'related-articles'){echo 'selected';}}?> value="related-articles">Related article</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'other'){echo 'selected';}}?> value="other">other</option>
            <option <?php if(isset($_GET['block_type'])){if($_GET['block_type'] == 'slider'){echo 'selected';}}?> value="slider">Slider</option>
        </select>
        
    </div>
    <div class="preloader">
        <div class="fa-2x">
            <i class="fas fa-sync fa-spin"></i>
        </div>
    </div>
    <div class="ekwa-admin-page-container">
            <div class="container-fluid  <?php if(isset($_GET['block_type'])){ echo 'btype_'.$_GET['block_type'];}?>" id="ekwa_headers">
                
                <div class="item-list">
                    
                </div>
                
                
                
                
                <ul class="list-group" id="headers_list">
                    
                </ul>
                
                
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

<style>
    .img-thumbnail{
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

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
<?php else: ?>
<div class="notice notice-warning is-dismissible" style="padding-top: 15px;padding-bottom: 15px;">
  <p>Need to install Advanced custom field Pro plugin to access this page</p>
  <p><a target="_blank" href="https://www.advancedcustomfields.com/pro/">Click here to download</a></p>
</div>
<?php endif?>