<?php
// If this file is called directly, abort. //
if (!defined('WPINC')) {
    die;
} // end if

// custom menu
function cpt_admin_menu()
{
    add_menu_page(
        'CPT',                         //page_title, 
        'Custom Post Types',          //menu_title,
        'manage_options',               //capability,
        'cpt-page-menu',                //menu_slug,
        'cpt_admin_page_contents',      //callable function
        'dashicons-admin-page',         // menu icon
        3                               //menu position
    );

    // custom submenu
    add_submenu_page(
        'cpt-page-menu',                        //parent_slug
        'Taxonomies',                          //page_title
        'Taxonomies',                          //menu_title
        'manage_options',                       //capability
        'tax-page-sub-menu',                    //menu_slug
        'cpt_sub_menu_admin_page_contents'      //callable $function
    );

     // custom submenu shortcode page
     add_submenu_page(
        'cpt-page-menu',                        //parent_slug
        'All Shortcode',                          //page_title
        'All Shortcode',                          //menu_title
        'manage_options',                       //capability
        'shortcode-page-sub-menu',                    //menu_slug
        'cpt_sub_menu_shortcode_page_contents'      //callable $function
    );

}
add_action('admin_menu', 'cpt_admin_menu');

/**
 *  CALL BACK FUNCTION CUSTOM POST TYPE
 */

function cpt_admin_page_contents()
{ 
    global $wpdb;
    ?>
    <div class="cpt_heading">
        <header class="cpt_header">
            <h1 class="cpt-h4"><?php echo '<h1>' . "Add New Custom Post Type" . '</h1>'; ?> </h1>
        </header>
    </div>
    <form method="POST">
    <div class="cpt-inside">
        <div class="cpt-field">
            <div class="cpt-label">
                <label for="cpt_post_name_label">
                Post name
                <span class="red_star">*</span>
                </label>
            </div>
            <div class="cpt-input">
                <input type="text" id="cpt_post_name_label" class="cpt_input" name="cpt_post_name" placeholder="Product" required="required">
            </div>
            <div class="cpt-label">
                <label for="cpt_slug_label">
                Slug
                <span class="red_star">*</span>
                </label>
            </div>
            <div class="cpt-input">
                <input type="text" id="cpt_slug_label" class="cpt_input" name="cpt_slug_name" placeholder="product" maxlength="20" required="required">
            </div>
            <p class="description">Lower case letters, underscores and dashes only, Max 20 characters.</p>
        </div>
        <div class="cpt_field_checkbox">
            <div class="cpt-label">
                <label>
                Supports
                </label>
           </div>
                <div class="main-checkbox">
                    <div class="col">
                        <ul class="ul-checkbox">
                            <li>
                                <label class="ckecked">
                                <input type="checkbox" name="supports[]" value="title"  checked readonly>
                                Title
                                </label>
                            </li>
                            <li>
                                <label>
                                <input type="checkbox" name="supports[]" value="editor" checked readonly>
                                Editor
                                </label>
                            </li>
                            <li>
                                <label>
                                <input type="checkbox" name="supports[]" value="thumbnail" checked readonly>
                                Featured Image
                                </label>
                            </li>
                            <li>
                                <label>
                                <input type="checkbox" name="supports[]" value="author" checked readonly>
                                Author
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="col">
                        <ul class="ul-checkbox">
                            <li>
                                <label class="ckecked">
                                <input type="checkbox" name="supports[]" value="comments" checked readonly>
                                Comments
                                </label>
                            </li>
                            <li>
                                <label>
                                <input type="checkbox" name="supports[]" value="excerpt">
                                Excerpt
                                </label>
                            </li>
                            <li>
                                <label>
                                <input type="checkbox" name="supports[]" value="custom-fields">
                                Custom Fields
                                </label>
                            </li>
                            <li>
                                <label>
                                <input type="checkbox" name="supports[]" value="revisions">
                                Revisions
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="col">
                        <ul class="ul-checkbox">
                            <li>
                                <label class="ckecked">
                                <input type="checkbox" name="supports[]" value="post-Formats">
                                Post Formats
                                </label>
                            </li>
                            <li>
                                <label>
                                <input type="checkbox" name="supports[]" value="trackbacks">
                                Trackbacks
                                </label>
                            </li>
                            <li>
                                <label>
                                <input type="checkbox" name="supports[]" value="page-attributes">
                                Page Attributes
                                </label>
                            </li>
                            <li>
                            <label>
                                <input type="checkbox" name="supports[]" value="hierarchical">
                                Hierarchical
                                </label>
                            </li>

                        </ul>
                    </div>
                </div>
        </div>
        <div class="cpt_btn">
            <button type="submit" class="save_cpt" name="submit">Save</button>
        </div>
    </div>
    </form>
    <?php
    
    $post_name = $slug =   $supports = '';
    if (isset($_POST['submit'])) {
        $post_name = isset($_POST['cpt_post_name']) ? $_POST['cpt_post_name']: '';
        $slug = isset($_POST['cpt_slug_name']) ? $_POST['cpt_slug_name'] : '';
        $supports = implode(",", $_POST['supports']);
       
        $string =    $slug;
        $str=(preg_match('/^[a-z_-]+$/', $string)); 
        
        $table_name = $wpdb->prefix . 'custom_post_type';

        $slugExistQuery = "SELECT slug FROM $table_name WHERE slug='".$slug."';";
        $result = $wpdb->query($slugExistQuery);
        if($result){
            echo '<div class="error"><p>This slug is Already Exists</p></div>';
            return;
        }
        elseif(!empty($post_name)  && !empty($str) && !empty($supports)  )
        {
            $table_name = $wpdb->prefix . 'custom_post_type';

            $wpdb->insert($table_name,array(

                'post_name'      =>            $post_name,
                'slug'           =>            $slug,
                'supports'       =>            $supports,
                'shortcode'      =>           '[cpt_title type="'.$slug.'"]'
            ));
            echo '<div class="updated"><p>Data inserted successfully!</p></div>';
                    
        }else
        { 
            echo '<div class="error"><p>Lower case letters, underscores and dashes only, Max 20 characters.</p></div>';

        }


    }

?>
<?php }

/**
 *  CALL BACK FUNCTION TAXONOMIES
 */

function cpt_sub_menu_admin_page_contents(){
     global $wpdb;
    ?>
    <div class="cpt_heading">
        <header class="cpt_header">
            <h4 class="cpt-h4"><?php echo '<h1>' . "Add New Taxonomy" . '</h1>'; ?> </h4>
        </header>
    </div>
    <form method="POST">
        <div class="tax_inside">
            <div class="tax-label">
                <label for="tax_cpt_label">
                Singular name
                <span class="red_star">*</span>
                </label>
            </div>
            <div class="tax-input">
                <input type="text" id="tax_cpt_label" class="tax_input" name="tax_singular_name" placeholder="Product" required="required">
            </div>
            <div class="tax-label">
                <label for="tax_slug_label">
                Slug
                <span class="red_star">*</span>
                </label>
            </div>
            <div class="tax-input">
                <input type="text" id="tax_slug_label" class="tax_input" name="tax_slug_name" placeholder="product" maxlength="20" required="required">
                <p class="description">Lower case letters, underscores and dashes only, Max 20 characters.</p>
            </div>
            <div class="tax-label">
                <label>Post Types</label>
            </div>
            <div class="tax-input">
            <?php
                        // Get post types
                            $args       = array(
                            'public' => true,
                            );
                            $post_types = get_post_types( $args, 'objects' );?>
                            <select class="select_post_option tax_input" name="select_post" placeholder="Select Product ID Type" required>
                            <option selected value="">Select</option>
                            <?php foreach ( $post_types as $post_type_obj ):
                            $labels = get_post_type_labels( $post_type_obj );
                            ?>
                            <option value="<?php echo esc_attr( $post_type_obj->name ); ?>"><?php echo esc_html( $labels->name ); ?></option>
                            <?php endforeach; ?>
                            </select>
                <p class="description">One or many post types that can be classified with this taxonomy.</p>
            </div>
            <div class="tax_btn">
                <button type="submit" class="save_tax" name="submit">Save</button>
            </div>
        </div>
    </form>
    
<?php 
    $singular = $slug =  $post_type = '';
        if(isset($_POST['submit']))
        {
            $singular = isset($_POST['tax_singular_name']) ? $_POST['tax_singular_name']:'';
            $slug = isset($_POST['tax_slug_name']) ? $_POST['tax_slug_name']:'';
            $post_type = isset($_POST['select_post']) ? $_POST['select_post']:'';

            $string  =    $slug;
            $str     =    (preg_match('/^[a-z_-]+$/', $string));

            $table_name = $wpdb->prefix . 'custom_taxonomy';

            $slugExistQuery = "SELECT slug FROM $table_name WHERE slug='".$slug."';";
            $result = $wpdb->query($slugExistQuery);
            if($result){
                echo '<div class="error"><p>This slug is Already Exists</p></div>';
            }
            elseif(!empty($singular)  && !empty($str) && !empty($post_type) )
            {
                $table_name = $wpdb->prefix . 'custom_taxonomy';
    
                $wpdb->insert($table_name,array(
                    
                    'singular_name'      =>          $singular, 
                    'slug'              =>            $slug,
                    'post_type'         =>            $post_type,
                     
                ));
                echo '<div class="updated"><p>Data inserted successfully!</p></div>';
                
                        
            }else
            { 
                echo '<div class="error"><p>Lower case letters, underscores and dashes only, Max 20 characters.</p></div>';
    
            }
    
        }

}
/**
 *  CALL BACK FUNCTION ALL SHORTCODE
 */

function cpt_sub_menu_shortcode_page_contents(){
    global $wpdb;?>
    <div class="cpt_heading">
        <header class="cpt_header">
            <h4 class="cpt-h4"><?php echo '<h1>' . "All Shortcodes" . '</h1>'; ?> </h4>
        </header>
    </div>
   <?php  $table_name = $wpdb->prefix . 'custom_post_type';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
    $i=1;?>
    <div class="main-table">
        <table class="table-fill">
            <thead>
                <tr>
                   <th scope="col" class="text-left" >S.no</th>
                    <th scope="col" class="text-left" >Post Name</th>
                    <th scope="col" class="text-left" >Short Code</th>
                </tr>
            </thead>
            <?php foreach($results as $result)
            {
                $post_name = $result->post_name;
                $shortcode = $result->shortcode;?>
                
                    <tbody class="table-hover">
                        <tr class="table-row">
                            <td class="text-left"><?php echo $i;?></td>
                            <td class="text-left"><?php echo $post_name;?></td>
                            <td class="text-left shortcode"><code class="code-text_<?php echo $i;?>"><?php echo $shortcode;?></code> 
                            <img src="<?php echo CPT_CORE_ADMIN_IMG.'copy.svg'; ?>" alt="copy-icon" class="icon-copy" onclick="copyToClipboard('.code-text_<?php echo $i;?>')"></td>                           
                        </tr>
                    </tbody>

                <?php $i++;
            }   
            ?>   
        </table>
    </div>
    
<?php }
/**
 *  CREATE CPT FUNCTION
 */
function create_new_cpt(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'custom_post_type';

    $results = $wpdb->get_results("SELECT * FROM $table_name");

    // echo '<pre>';
    // print_r($results);
    // echo '</pre>';
    // die();

    foreach($results as $result){
        $post_name = $result->post_name;
        $slug = $result->slug;
        $supports =  array_map('trim', explode(',', $result->supports));
       
        $labels = array(
            'name'               => _x( $post_name, 'post type general name' ),
            'singular_name'      => _x( $post_name, 'post type singular name' ),
            'add_new'            => _x( 'Add New', $post_name ),
            'add_new_item'       => __( 'Add New '.$post_name ),
            'edit_item'          => __( 'Edit '.$post_name ),
            'new_item'           => __( 'New '.$post_name ),
            'all_items'          => __( 'All '.$post_name ),
            'view_item'          => __( 'View '.$post_name ),
            'search_items'       => __( 'Search '.$post_name ),
            'not_found'          => __( 'No '.$post_name.' found' ),
            'not_found_in_trash' => __( 'No '.$post_name.' found in the Trash' ), 
            'parent_item_colon'  => '',
            'menu_name'          =>$post_name
        );
        
        $args = array(
            'labels'        => $labels,
            'description'   => $post_name,
            'public'        => true,
            'show_ui'        => true,
            'capability_type'  => 'post',
            'menu_position' => 5,
             'supports'      => $supports,
            'has_archive'   => true,
        );   
        
          register_post_type( $slug, $args );
    }
    
}
  add_action('init','create_new_cpt');


/**
 *  ADD SHORTCODE DISPLAY ALL POST FUNCTION
 */
  add_shortcode('cpt_title','cpt_get_cpt_pots');

  function cpt_get_cpt_pots($attr){
    ob_start();
    $args = array(
        'post_type' => $attr['type'],
        'posts_per_page' => -1,
        'order'   => 'DESC',
        'post_status' => 'publish'

    );
    $query = new WP_Query($args);

    if($query->have_posts()):
        while($query->have_posts()): $query->the_post();
        $id = get_the_ID(); 
        $content = get_post_field("post_content", $id); 
        $title = get_the_title($id); 
        $image = wp_get_attachment_url(get_post_thumbnail_id($id));?>
        <div class="col">
            <h4><?php echo $title; ?></h4>
            <?php if(isset($image) && $image){?>
                <img src="<?php echo $image; ?>" alt="post-img" style="width:200px;">
            <?php } ?>
            <p><?php echo $content; ?></p>
        </div>


   <?php  endwhile;
   
    endif;
    $out= ob_get_clean();
    return $out;
  }
/**
 *  CREATE TAXONOMY FUNCTION
 */
  function create_new_taxonomy(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_taxonomy';
    $results = $wpdb->get_results("SELECT * FROM $table_name");

    foreach($results as $result){
        $singluar_name =  $result->singular_name;
        $slug          =  $result->slug;
        $post_type     = $result->post_type;

        $category_labels = array(
            'name'              => _x( $singluar_name , 'taxonomy general name' ),
            'singular_name'     => _x( $singluar_name , 'taxonomy singular name' ),
            'search_items'      => __( 'Search '.$singluar_name .'' ),
            'all_items'         => __( 'All '.$singluar_name. '' ),
            'parent_item'       => __( 'Parent '.$singluar_name .'' ),
            'parent_item_colon' => __( 'Parent '.$singluar_name .'' ),
            'edit_item'         => __( 'Edit '.$singluar_name.''  ),
            'update_item'       => __( 'Update '.$singluar_name .'' ),
            'add_new_item'      => __( 'Add New '.$singluar_name .'' ),
            'new_item_name'     => __( 'New '.$singluar_name .' Name' ),
            'menu_name'         => __( $singluar_name  ),
        );
    
    
        $category_args = array(
            'hierarchical'      => true,
            'labels'            => $category_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           =>  $slug,
        );
        register_taxonomy(  $slug, $post_type, $category_args );
    }

  }
  add_action('init','create_new_taxonomy');

