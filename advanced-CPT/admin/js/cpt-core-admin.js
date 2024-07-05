var cpt_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function($) {
    $("#cpt_post_name_label").on('input', function () {
        var postName = $(this).val(); // Get the value of #cpt_post_name_label
        var slug = postName.replace(/\s+/g, '-').toLowerCase(); // Convert it to lowercase and replace space with dash
    
        
        $("#cpt_slug_label").val(slug); // Set the value of #cpt_slug_label to the lowercase value
    });
    $("#tax_cpt_label").on('input', function () {
        var postName = $(this).val(); // Get the value of #cpt_post_name_label
        var slug = postName.replace(/\s+/g, '-').toLowerCase(); // Convert it to lowercase and replace space with dash
    
        
        $("#tax_slug_label").val(slug); // Set the value of #cpt_slug_label to the lowercase value
    });
    $('.icon-copy').click(function(){
       
    });
   
});

function copyToClipboard(element)
{
    var $temp = jQuery("<input>");
    jQuery("body").append($temp);
    $temp.val(jQuery(element).text()).select();
    document.execCommand("copy");
    Swal.fire({
        icon: 'success',
        title: 'Text copied to clipboard',
        text: jQuery(element).text(),
        showConfirmButton: false,
        timer: 3000
    });
    $temp.remove();
}

