/*
var myarray = [1,2,3];

if(jQuery.inArray('1', myarray) == -1){
    console.log('not in array')
} else{
    console.log('in array');
}
*/







 // main page functions 
  $(".main-page").click(function(){
    
    var settings = {
                    "async": true,
                    "url": ajaxurl,
                    "method": "POST",
                    data: {
                            'testing': 'abcd',
                            action: 'import_ekwa_lazyload'
                    }
                }
            
            $.ajax(settings).done(function(response){
                 //$(".preloader").hide();
                //location.reload(); 
                console.log(response);
                
            })

    
    
    
  })








$(document).ready(function(){
  if (BlocksLibrary) {
     document.getElementById('select-block-type').addEventListener('change', function() {
        //console.log('You selected: ', this.value);
        window.location.href = SITEURL+"&block_type="+this.value;
      });
  }

 
  
  var ajaxurl = $(".ekwa-admin-page").data('url');
    var resourceType = $(".ekwa-admin-page").data('type');
    var resourcesCategory = $(".ekwa-admin-page").data('category');
    var Directory = $(".ekwa-admin-page").data('directory');
          
  runAjax();

function runAjax(filter = null){

// var PerPage = localStorage.getItem('Perpage');
PerPage = 6;
//console.log(blockType)


if (BlocksLibrary) {
  var dataURL = 'https://components.ekwa-testbench.info/wp-json/wp/v2/components?filter[meta_query][0][key]=category&filter[meta_query][0][value]=blocks&filter[meta_query][0][key]=block_type&filter[meta_query][0][value]='+blockType+'&per_page=10&page=1';
}else{
  var dataURL = 'https://components.ekwa-testbench.info/wp-json/wp/v2/components?filter[meta_query][0][key]=category&filter[meta_query][0][value]='+resourceType+'&per_page=10&page=1';  
}

var totalItems;
 

$('#pagination-container').pagination({

  
  alias: {
    pageNumber: 'page',
    pageSize: 'per_page'
},
  ulClassName: 'pagination pg-blue',
  activeClassName: 'active',
  ajax: {
    beforeSend: function() {
      $(".preloader").show();
        // $("#studentInfo").html('Loading ...');
        //// $("#preloader_home").hide();
    //console.log('preloading can add here')

    }
},
  dataSource: dataURL,
  locator: 'items',
  totalNumberLocator: function(response) {
    console.log(response);
    
      /*
    console.log(sessionStorage.getItem('Total'))
    return  sessionStorage.getItem('Total')*/
    if(totalItems){
      console.log(totalItems);
      var TOTAL = totalItems;
    }else{
      if (blockType == 'headers') {

        if (response.length == 0) {
            //console.log('no responise');
            var TOTAL = 0;
        }else{
          var TOTAL = response[0].total_headers;
        }
        
        
      }
      if (blockType == 'footers') {
        
         if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_footers;
          }
      }
      if (blockType == 'content') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_content;
          }
      }
      if (blockType == 'service-boxes') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_service_boxes;
          }
      }
      if (blockType == 'headline') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_headline;
          }
      }
      if (blockType == 'button') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_button;
          }
      }
      if (blockType == 'call-to-action') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_cta;
          }
      }
      if (blockType == 'team') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_team;
          }
      }
      if (blockType == 'contact') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_contact;
          }
      }
      if (blockType == 'pricing') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_pricing;
          }
      }
      if (blockType == 'logos') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_logos;
          }
      }
      if (blockType == 'related-articles') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_rarticles;
          }
      }
      if (blockType == 'slider') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_slider;
          }
      }
      if (blockType == 'other') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_other;
          }
      }
      if (blockType == 'hero') {
        
        if (response.length == 0) {
            var TOTAL = 0;
          }else{
            var TOTAL = response[0].total_hero;
          }
      }
      
      
    }
    $("#totalPosts").html(TOTAL);
    return  TOTAL;
      
  },
  pageSize: PerPage,
  
  callback: function(data, pagination) {
      // template method of yourself
      $(".preloader").fadeOut();
      var html = template(data);
      $("#headers_list").html(html);
      $(".header-item").click(function(e){
                
                var ekwaRtype  = $('.ekwa-admin-page').data("type");
     
                  e.preventDefault();
                 headerOnClick(this);
                
                //var downloadLink = 
                //headerOnClick(this);
                
    })
      
      
      //$("#preloader_home").hide();
/*
      $(".personEdit").click(function(){
        let personID = this.getAttribute('id');
        console.log(personID)
       sessionStorage.setItem('personID', personID);
        tabber.setActiveTab(1);
      })*/


  }
})



function template(data) {
  var html = "";
  var notInstalled = true;
  var Visibility = 'visible';
  var linkOpen = '';
  var linkClose = '';
  var downloadBTN = '';
  console.log(data);
  $.each(data, function(index, item){
    
    if(jQuery.inArray(this.id, installedHeaders) == -1){
      var JsnFile = 'no-file';
      var JsnFileName = "no-file-name";
      var resourceName = this.title.rendered;
      if (this.acf.json_file) {
        JsnFile = this.acf.json_file;
        JsnFileName = JsnFile.substring(JsnFile.lastIndexOf('/')+1);
      }
      var blockName = 'no-acf-block';
      if (this.acf.block_slug) {
        var blockName = this.acf.block_slug;
      }
      
      notInstalled = true;
      Visibility = 'visible';
      
       linkOpen = `<a class="header-item btn btn-primary btn-sm" data-bname="${blockName}" data-title="${resourceName}" target="_blank" href="${this.acf.file}" data-id="${this.id}" data-jsn="${JsnFile}" data-flname="${JsnFileName}" data-img="${this.acf.thumbnail}">`;
       linkClose = `</a>`;
       downloadBTN = `<button class="btn btn-primary"><i class="fas fa-download"></i> Download </button>`;
    }else{
      notInstalled = false;
      Visibility = 'd-none';
       linkOpen = `<span class="hidden">`;
       linkClose = `</span>`;
    }
    
      html += `
      <li class="list-group-item row-header ${Visibility}">


      <img src="${this.acf.thumbnail}" >
      <span class="btn-group-right">
            ${linkOpen}<i class="fas fa-download"></i> Download${linkClose}
            <a target="_blank" href="${this.acf.thumbnail}" type="button" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> Preview</a>
      </span>
      </li>`;
                    
      
  });

  return html;
}


}

// end of runajax function





function headerOnClick(element) {
  
  console.log(resourceType + 'working');
  
  
            $(".preloader").show();
            console.log(element);
            var DownloadLink = $(element).attr('href');
            var itemId = $(element).data('id');
            var thumbUrl = $(element).data('img');
            var dataJson = $(element).data('jsn');
            var dataJsonFile = $(element).data('flname');
            var reName = $(element).data('title');
            var bName = $(element).data('bname');

            // here needs to check if the itemId in the resource post type
        
            
            var settings = {
                    "async": true,
                    "url": ajaxurl,
                    "method": "POST",
                    data: {
                            downloadLink: DownloadLink,
                            id: itemId,
                            resourceType: resourceType,
                            resourceCategory: resourcesCategory,
                            downloadDirectory: Directory,
                            thumbUrl: thumbUrl,
                            dataJson: dataJson,
                            dataJsonFile: dataJsonFile,
                            resourcesName: reName,
                            blockName: bName,
                            
                            action: 'download_resources'
                    }
                }
            
            $.ajax(settings).done(function(response){
                 //$(".preloader").hide();
                location.reload(); 
                console.log(response);
                
            })
            
        
    }

$(".deleteItem").click(function(e){
        var DeletePostID = $(this).data('postid');
        var DeleteDirectory =  Directory;
        var DeleteResourceID = $(this).data('id');
        var DeleteJsonFile = $(this).data('file');
        var BlockSlug = $(this).data('slug');
        
        $("#deleteModal").modal('show');
        
        $(".delete_confirmed").click(function(){
            
        $("#deleteModal").modal('hide');

         var settings = {
                    "async": true,
                    "url": ajaxurl,
                    "method": "POST",
                    data: {
                        
                            post_id: DeletePostID,
                            directory: DeleteDirectory,
                            resource_id: DeleteResourceID,
                            json_file: DeleteJsonFile,
                            block_slug: BlockSlug,
                            action: 'delete_resource'
                    }
                }
                
            
            $.ajax(settings).done(function(response){
                location.reload(); 
                console.log(response);
                
            })
            
        
        
        });
        
    })






})
// document ready

