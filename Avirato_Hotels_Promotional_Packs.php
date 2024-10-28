<?php
if (!defined('ABSPATH'))
  exit;
/*
Plugin Name: Avirato Hotels Promotional Packs
Plugin URI: https://es.wordpress.org/plugins/avirato-hotels-promotional-packs/
Description: Give your customers an easy access to your Promotional Packs with.
Version: 2.0.1
Author: Avirato
Author URI: https://avirato.com/
Text Domain: avirato-hotels-promotional-packs
Domain Path: /languages
*/

function ahop_textdomain()
{
  $text_domain = 'avirato-hotels-promotional-packs';
  $path_languages = basename(dirname(__FILE__)) . '/languages/';
  load_plugin_textdomain($text_domain, false, $path_languages);
}

if (!function_exists('PostCreator')) {

  function PostCreator($name = 'AUTO POST', $type = 'post', $category = array(1, 2), $author_id = '1', $status = 'publish')
  {
    define(AHOP_POST_NAME, $name);
    define(AHOP_POST_TYPE, $type);
    define(AHOP_POST_CATEGORY, $category);
    define(AHOP_POST_AUTH_ID, $author_id);
    define(AHOP_POST_STATUS, $status);
    if ($type == 'page') {
      $post = get_page_by_title(AHOP_POST_NAME, 'OBJECT', $type);
      $post_id = $post->ID;
      $post_data = get_page($post_id);
    } else {
      $post = get_page_by_title(AHOP_POST_NAME, 'OBJECT', $type);
      $post_id = $post->ID;
      $post_data = get_post($post_id);
    }

    function ahop_create_post()
    {
      $post_data = array(
        'post_author' => AHOP_POST_AUTH_ID,
        'post_content' => '[Avirato_paquetes]',
        'post_title' => wp_strip_all_tags(AHOP_POST_NAME),
        'post_status' => AHOP_POST_STATUS,
        'post_type' => AHOP_POST_TYPE,
        'post_category' => AHOP_POST_CATEGORY,
      );
      wp_insert_post($post_data, $error_obj);
    }

    if (!isset($post)) {
      add_action('admin_init', 'ahop_create_post');
      return $error_obj;
    }
  }
}

function ahop_create_tables()
{
  global $wpdb;

  $table_name1 = $wpdb->prefix . 'ahop_textComp_offerPacks';
  $table_name2 = $wpdb->prefix . 'ahop_cats_offerPacks';
  $sql1 = "CREATE TABLE $table_name1 (
    id int(11) NOT NULL AUTO_INCREMENT,
    textoCompleto longtext NOT NULL,
    PRIMARY KEY (id)
  );";
  $sql2 = "CREATE TABLE $table_name2 (
    id int(11) NOT NULL AUTO_INCREMENT,
    id_paquetes int(11) NOT NULL,
    categoria varchar(255) NOT NULL,
    background_color varchar(50) NOT NULL,
    text_color varchar(50) NOT NULL,
    PRIMARY KEY (id)
  );";
  //upgrade contiene la función dbDelta la cuál revisará si existe la tabla o no
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  //creamos la tabla
  dbDelta($sql1);
  dbDelta($sql2);
}

function ahop_remove_tables()
{
  global $wpdb;
  $table_name1 = $wpdb->prefix . 'ahop_textComp_offerPacks';
  $sql1 = "DROP table IF EXISTS $table_name1";
  $wpdb->query($sql1);
  $table_name2 = $wpdb->prefix . 'ahop_cats_offerPacks';
  $sql2 = "DROP table IF EXISTS $table_name2";
  $wpdb->query($sql2);
}

function ahop_aviratoOfferPacks_plugin_menu_admin()
{
  //Añade una página de menú a wordpress
  $pageTitle = __('Avirato Hotels Promotional Packs', 'avirato-hotels-promotional-packs');
  $menuTitle = __('Avirato Promo Packs', 'avirato-hotels-promotional-packs');
  if (empty($GLOBALS['admin_page_hooks']['ahs_aviratoSuite-content-settings'])) {
    add_menu_page(
      'Avirato Hotels Suite', //Título de la página
      'Avirato Suite', //Título del menú
      'administrator', //Rol(capability) que puede acceder
      'ahs_aviratoSuite-content-settings', //Id de la página de opciones
      'ahs_aviratoSuite_content_page_settings', //Función que pinta la página de configuración del plugin
      plugins_url('includes/icons/icon-18x18.png', __FILE__) // Icono del menú
    );
    add_submenu_page(
      'ahs_aviratoSuite-content-settings',
      $pageTitle, //Título de la página
      $menuTitle, //Título del menú
      'administrator', //Rol(capability) que puede acceder
      'ahop_aviratoOfferPacks-content-settings', //Id de la página de opciones
      'ahop_aviratoOfferPacks_content_page_settings' //Función que pinta la página de configuración del plugin
    );
    function ahs_aviratoSuite_content_page_settings()
    {
      $needHelpTrans = __('Need help?', 'avirato-hotels-promotional-packs');
      $helpCenter = __('Help Center', 'avirato-hotels-promotional-packs');
      $suiteTrans1 = __('Everything your business needs, integrated into single reservation management software.', 'avirato-hotels-promotional-packs');
      $suiteTrans2 = __('PMS + CHANNEL MANAGER + REVENUE MANAGER + BOOKING ENGINE + POS RESTAURANT + WEB DESIGN', 'avirato-hotels-promotional-packs');
      $suiteTrans3 = __("We put at your disposal our new help center, where you will find a solution to all your doubts related to Avirato's services and products.", 'avirato-hotels-promotional-packs');
      $suiteRemote = __('Remote assistance', 'avirato-hotels-promotional-packs');
      $suiteRemoteText = __('If you need direct support on your equipment, a qualified technician will connect with you to help you remotely and from our offices.', 'avirato-hotels-promotional-packs');
      $suiteWebinars = __('Improve the use of your management tool or learn the basic concepts of utility and operation by targeting our periodic Webinars.', 'avirato-hotels-promotional-packs');
      $suiteManual = __('Improve the use of your management tool or learn the basic concepts of utility and operation by targeting our periodic Webinars.', 'avirato-hotels-promotional-packs');
      $suiteManualButton = __('User Manual', 'avirato-hotels-promotional-packs');
?>
      <h2 id="ahc_logo" style="
        width: calc( 100% - 40px );
        background-color: #4F4F5D;
        margin-left: 0;
        text-align: right;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px;
        height: 36px !important;
      ">
        <img src="<?= plugins_url('includes/icons/avirato-logo.png', __FILE__) ?>" alt="Avirato Calendar" style="height: 32px;">
        <a href="https://avirato.com/atencion-al-cliente/" target="_blank" style="padding-right:25px; line-height: 5; color:#fff; font-size:20px;"><?= $needHelpTrans ?></a>
      </h2>
      <h1 style="font-size: 3em; text-align: center; line-height: 1;"><?= $suiteTrans1 ?></h1>
      <h3 style="text-align:center;"><?= $suiteTrans2 ?></h3>
      <div style="margin-top:50px;">
        <h2 style=" font-size: xx-large; text-align:center;"><?= $helpCenter ?></h2>
      </div>
      <div>
        <h3 style="text-align:center;"><?= $suiteTrans3 ?></h3>
      </div>
      <div class="ahc-row">
        <div class="ahc-widget-wrap">
          <div class="ahc-widget-container">
            <div class="ahc-image-box-wrapper">
              <figure class="ahc-image-box-img">
                <img height="90" src="<?= plugins_url('includes/icons/Icono-soporte-directo-.png', __FILE__) ?>" class="ahc-animation-grow attachment-full size-full" alt="">
              </figure>
              <div class="ahc-image-box-content">
                <h2 class="ahc-image-box-title"><?= $suiteRemote ?></h2>
                <p class="ahc-image-box-description"><?= $suiteRemoteText ?></p>
              </div>
            </div>
          </div>
          <div class="ahc-button-wrapper">
            <a href="https://anydesk.com/es/downloads" class="ahc-button-link ahc-button ahc-size-sm" target="_blank" role="button">
              <span class="ahc-button-text"><?= $suiteRemote ?></span>
            </a>
          </div>
        </div>
        <div class="ahc-widget-wrap">
          <div class="ahc-widget-container">
            <div class="ahc-image-box-wrapper">
              <figure class="ahc-image-box-img">
                <img height="90" src="<?= plugins_url('includes/icons/icono-WEBINARS-PROXIMOS.png', __FILE__) ?>" class="ahc-animation-grow attachment-full size-full" alt="">
              </figure>
              <div class="ahc-image-box-content">
                <h2 class="ahc-image-box-title">Webinars</h2>
                <p class="ahc-image-box-description"><?= $suiteWebinars ?></p>
              </div>
            </div>
          </div>
          <div class="ahc-button-wrapper">
            <a href="https://ayuda.avirato.com/webinars-avirato/" class="ahc-button-link ahc-button ahc-size-sm" target="_blank" role="button">
              <span class="ahc-button-text">Webinars Avirato</span>
            </a>
          </div>
        </div>
        <div class="ahc-widget-wrap">
          <div class="ahc-widget-container">
            <div class="ahc-image-box-wrapper">
              <figure class="ahc-image-box-img">
                <img height="90" src="<?= plugins_url('includes/icons/Icono-manual-de-usuario.png', __FILE__) ?>" class="ahc-animation-grow attachment-full size-full" alt="">
              </figure>
              <div class="ahc-image-box-content">
                <h2 class="ahc-image-box-title">Manual</h2>
                <p class="ahc-image-box-description"><?= $suiteManual ?></p>
              </div>
            </div>
          </div>
          <div class="ahc-button-wrapper">
            <a href="https://avirato.com/manual_de_usuario/" class="ahc-button-link ahc-button ahc-size-sm" target="_blank" role="button">
              <span class="ahc-button-text"><?= $suiteManualButton ?></span>
            </a>
          </div>
        </div>
      </div>

  <?php
    }
  } else {
    add_submenu_page(
      'ahs_aviratoSuite-content-settings',
      $pageTitle,
      $menuTitle, //Título del menú
      'administrator', //Rol(capability) que puede acceder
      'ahop_aviratoOfferPacks-content-settings', //Id de la página de opciones
      'ahop_aviratoOfferPacks_content_page_settings' //Función que pinta la página de configuración del plugin
    );
  }
}

function ahop_AjaxConn_Enq($hook)
{
  $screen = get_current_screen();
  if (in_array($screen->id, array('avirato-suite_page_ahop_aviratoOfferPacks-content-settings'))) {
    wp_enqueue_script('ajaxCallOP', plugins_url('includes/js/ajaxCallOP.js', __FILE__), array('jquery'));
    wp_enqueue_script('ajaxMultiOP', plugins_url('includes/js/ajaxMultiOP.js', __FILE__), array('jquery'));
    wp_localize_script('ajaxCallOP', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'we_value' => 1234));
    wp_localize_script('ajaxMultiOP', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'we_value' => 1234));
  }
}

function ahop_AjaxConnOP()
{
  $codeCon = sanitize_text_field($_POST['codecon']);
  /* if(isset($codeCon) && !empty($codeCon)){ */
  $body = array(
    'codecon' => $codeCon
  );
  $args = array(
    'body' => $body,
    'timeout' => '45',
    'redirection' => '5',
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => array(),
    'cookies' => array(),
    'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url()
  );
  $co = $codeCon;


  $response = wp_remote_post("https://booking.avirato.com/api/$co/promotions", $args);

  if (is_wp_error($response)) {
    $error_message = $response->get_error_message();
    alert($error_message);

    function alert($msg)
    {
      echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    //echo "Something went wrong: $error_message";
  } else {
    $html = $response['body'];
    $result = [];
    $responsePackagesPromotions = json_decode($html);
    if (isset($responsePackagesPromotions->data)) {
      $result = $responsePackagesPromotions->data;
    }
    if (strpos(result)) {
    }
    $result = json_encode($result);
    ahop_insert_cal($result);
    echo $response['body'];
    wp_die();
  }

  /* }else{
    alert("Hello World");
    function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
  }
} */
}

function ahop_AjaxMulti()
{
  $htmlMultiOP = sanitize_text_field($_POST['htmlMultiOP']);
  $html = $htmlMultiOP;
  ahop_insert_cal1Cat($html);
  echo $html;
  wp_die();
}

function ahop_insert_cal1Cat($html)
{
  $parts = explode('***', $html);
  global $wpdb;
  $table_name2 = $wpdb->prefix . 'ahop_cats_offerPacks';
  $sql2 = "DROP table IF EXISTS $table_name2";
  $wpdb->query($sql2);
  $sql3 = "CREATE TABLE $table_name2 (
    id int(11) NOT NULL AUTO_INCREMENT,
    id_paquetes int(11) NOT NULL,
    categoria varchar(255) NOT NULL,
    background_color varchar(50) NOT NULL,
    text_color varchar(50) NOT NULL,
    PRIMARY KEY (id)
  );";
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql3);


  foreach ($parts as $cate) {
    $cateParts = explode('-------', $cate);
    $catesubparts = explode(',', $cateParts[1]);

    foreach ($catesubparts as $value) {
      $wpdb->insert(
        $table_name2,
        array(
          'id_paquetes' => $value, 'categoria' => $cateParts[0], 'background_color' => $cateParts[2], 'text_color' => $cateParts[3]
        )
      );
    }
  }
}

function ahop_insert_cal($html)
{
  if (isset($_POST["codecon"]) && !empty($_POST["codecon"])) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'ahop_textComp_offerPacks';
    $res = $wpdb->get_results('SELECT textoCompleto FROM ' . $table_name . ' WHERE id = 1', OBJECT);
    if (count($res) > 0) {
      $table_name = $wpdb->prefix . 'ahop_textComp_offerPacks';
      $wpdb->update(
        $table_name,
        array(
          'textoCompleto' => $html
        ),
        array('id' => 1)
      );
    } else {
      $wpdb->insert(
        $table_name,
        array(
          'textoCompleto' => $html
        )
      );
    }
  }
}

function ahop_insert_button()
{
  global $wpdb;
  $table_name1 = $wpdb->prefix . 'ahop_text_button';
  $res1 = $wpdb->get_results('SELECT botones_avirato FROM ' . $table_name1 . '', OBJECT);

  if (count($res1) < 1) {
    $ahop_link = ahop_button_link_db();
    foreach ($ahop_link as $link) {
      $table_name1 = $wpdb->prefix . 'ahop_text_button';
      $wpdb->insert(
        $table_name1,
        array(
          'botones_avirato' => $link
        )
      );
    }
  } else {
    $table_name1 = $wpdb->prefix . 'ahop_text_button';
    $wpdb->query("TRUNCATE TABLE $table_name1");
    $ahop_link = ahop_button_link_db();
    foreach ($ahop_link as $link) {
      $table_name1 = $wpdb->prefix . 'ahop_text_button';
      $wpdb->insert(
        $table_name1,
        array(
          'botones_avirato' => $link
        )
      );
    }
  }
}

function ahop_aviratoOfferPacks_content_page_settings()
{
  $calendarTrans = __('GENERATOR', 'avirato-hotels-promotional-packs');
  $helpTrans = __('HELP', 'avirato-hotels-promotional-packs');
  $generatorTrans = __('GENERATOR', 'avirato-hotels-promotional-packs');
  $webcodeTrans = __('Web Code', 'avirato-hotels-promotional-packs');
  $generateTrans = __('GENERATE', 'avirato-hotels-promotional-packs');
  $integrationTitleTrans = __('INTEGRATION', 'avirato-hotels-promotional-packs');
  $integrationTextTrans = __('To make offer packs visible just add the new "Paquetes Promocionales" page link to your main menu.', 'avirato-hotels-promotional-packs');
  $integrationText2Trans = __('Download Avirato PMS completly free', 'avirato-hotels-promotional-packs');
  $dialogTrans = __('The following code has been generated', 'avirato-hotels-promotional-packs');
  $selectorTrans = __('SELECTOR', 'avirato-hotels-promotional-packs');
  $propTrans = __('Selector', 'avirato-hotels-promotional-packs');
  $packIdsTrans = __('PACK`S ID', 'avirato-hotels-promotional-packs');
  $packIdsTransa = __('CATEGORIES', 'avirato-hotels-promotional-packs');
  $needHelpTrans = __('Need help?', 'avirato-hotels-promotional-packs');
  $packages = getPromotionPackagesFromDatabase();
  $catstable = getPromotionPackagesCatFromDatabase();
  ?>

  <div id="dialog-confirm" title="<?= $dialogTrans ?>:">

  </div>
  <h2 id="ahc_logo" style="
    width: calc( 100% - 40px );
    background-color: #4F4F5D;
    margin-left: 0;
    text-align: right;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    height: 36px !important;
  ">
    <img src="<?= plugins_url('includes/icons/avirato-logo.png', __FILE__) ?>" alt="Avirato Calendar" style="height: 32px;">
    <a href="https://avirato.com/atencion-al-cliente/" target="_blank" style="padding-right:25px; line-height: 5; color:#fff; font-size:20px;"><?= $needHelpTrans ?></a>
  </h2>

  <div class="ahop_wrap">
    <div class="ahop_tab">
      <button class="ahop_tablinks active" onclick="ahop_open_tab(event, 'Calendario_1')"><?= $calendarTrans ?></button>

      <button class="ahop_tablinks" onclick="ahop_open_tab(event, 'Calendario_3')"><?= $helpTrans ?></button>
    </div>
    <div id="Calendario_1" class="ahop_tabcontent">
      <div id="ahop_container1">

        <h3 class="ahop_conTitle"><?= $generatorTrans ?></h3>
        <form action="" method="POST">
          <div class="code_container">
            <label><?= $webcodeTrans ?>:</label>
            <input id="codecon" name="codecon" type="text" required="">
          </div><br>
          <button id="ahop_externo"><?= $generateTrans ?></button>
        </form>
        <div id="ahop_container3">
          <h3 class="ahop_conTitle"><?= $integrationTitleTrans ?></h3>
          <div>
            <p id="ahop_shortcode_text">* <?= $integrationTextTrans ?></p>
            <p><?= $integrationText2Trans ?>: <a href="https://avirato.com/instalacion-programa/" target="_blank">Avirato PMS</a> </p>
          </div>
        </div>
      </div>
      <div id="ahop_container4">
        <h3 class="ahop_conTitle"><?= $packIdsTrans ?></h3>
        <div style="   width: 100%;    background: #fff;    padding: 20px;    box-sizing: border-box;    ">
          <?php
          $toPrint = '';

          foreach ($packages as $package) {
            $toPrint .= 'id -> ' . $package->package_id . '  ------  ' . $package->nombre_es . '<br>';
          };
          if ($toPrint == '') {
          ?>
            <h3>Generate your offer packs to get its ID`s</h3>
          <?php
          } else {
            echo $toPrint;
          }
          ?>
        </div>
      </div>
      <div id="ahop_container2">
        <h3 class="ahop_conTitle"><?= $selectorTrans ?></h3>
        <div id="multiCal" class="ahop_radioContent" style="   width: 100%;    background: #fff;    padding: 20px;    box-sizing: border-box;">
          <div class="code_container" id="multiEstab">
            <h3 id="ahop_alertInput" style='color:red'><?= $alertTrans ?></h3>
            <label class="catCount"><?= $propTrans ?> 1:</label>
            <input id="catcon1" name="catcon1" type="text" required="" placeholder="Category">
            <input id="idscon1" name="idscon1" type="text" required="" placeholder="ID`s" onkeypress="return valida(event)">
            <label>Text Background Color:</label>
            <input id="colorcon1" name="colorcon1" type="color" required="">
            <label>Text Color:</label>
            <input id="textColorcon1" name="textColorcon1" type="color" required="">

          </div>
          <div style="text-align: center;">
            <button id="addEstab" onclick="newCat()">+</button>
            <button id="removeEstab" onclick="remNewCat()">-</button>
          </div>

          <!--<button id="ahop_externo1" onclick="acip_replaceCurrTable()"></button>-->
          <button id="ahop_externo1" onclick="ahop_replaceCurrTable()"><?= $generateTrans ?></button>
          <div id="ahop_noShow"></div>

        </div>
      </div>
      <div id="ahop_container5">
        <h3 class="ahop_conTitle"><?= $packIdsTransa ?></h3>
        <div style="   width: 100%;    background: #fff;    padding: 20px;    box-sizing: border-box;">
          <?php
          $toPrinta = '';

          foreach ($catstable as $packagea) {
            $toPrinta .= 'id -> ' . $packagea->id_paquetes . '  ------  ' . $packagea->categoria . '<br>';
          };
          if ($toPrinta == '') {
          ?>
            <h3>Generate your Categories to get the list</h3>
          <?php
          } else {
            echo $toPrinta;
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <!-- HELP TAB -->
  <div id="Calendario_3" class="ahop_tabcontent">
    <?php
    $worksTrans = __('How Avirato Hotels Promotional Packs works', 'avirato-hotels-promotional-packs');
    $worksTrans1 = __('To integrate the Promotional Packs form your Avirato PMS on your site, just follow a few simple steps', 'avirato-hotels-promotional-packs');
    $worksTrans2 = __('Generate the Promotional Packs', 'avirato-hotels-promotional-packs');
    $worksTrans3 = __('You should contact Avirato to provide the "Web Code"." <br> Phone', 'avirato-hotels-promotional-packs');
    $worksTrans4 = __('After this enter the data that you have provided in the corresponding field and press "Generate"', 'avirato-hotels-promotional-packs');
    $worksTrans5 = __('A popup will appear with a text message, press "OK"', 'avirato-hotels-promotional-packs');
    $worksTrans6 = __('Adding the Promotional Packs', 'avirato-hotels-promotional-packs');
    $worksTrans7 = __('Use the "Paquetes Promocionales" page created by the plugin. Just add the page to your navigation menu.', 'avirato-hotels-promotional-packs');
    $worksTrans10 = __('Create the Categories', 'avirato-hotels-promotional-packs');
    $worksTrans11 = __('To create the categories for your Promotional Packs, on the "SELECTOR" box introduce: ', 'avirato-hotels-promotional-packs');
    $worksTrans12 = __('The category name in the first field under "Selector 1"', 'avirato-hotels-promotional-packs');
    $worksTrans12_1 = __('Asign promotional packs to this category filling the second field (ID´s) under "selector 1" with ALL the id´s from the packs you want to include separated by ",". Ex: 1,3,5....', 'avirato-hotels-promotional-packs');
    $worksTrans12_2 = __('Asign a background color for this category by clicking on the box under "Text Background Color".', 'avirato-hotels-promotional-packs');
    $worksTrans12_3 = __('Asign a text color for this category by clicking on the box under "Text Color".', 'avirato-hotels-promotional-packs');
    $worksTrans12_4 = __('Add/remove categories by using "+" or "-" buttons.', 'avirato-hotels-promotional-packs');
    $worksTrans12_5 = __('Once you have all your categories, click "GENERATE"', 'avirato-hotels-promotional-packs');
    $worksTrans13 = __('You can view the promotional pack id/category relationship in "CATEGORIES" box once you have generated your catagories.', 'avirato-hotels-promotional-packs');
    $worksTrans14 = __('All Promotional Packs unassociated to a category, was automatically associated to "Other" category.', 'avirato-hotels-promotional-packs');
    $worksTrans16 = __('After making the changes press "Update"', 'avirato-hotels-promotional-packs');


    ?>
    <h3 class="ahop_conTitle"><?= $worksTrans ?></h3>
    <div id="ahop_cal3_cont">

      <p><?= $worksTrans1 ?></p>
      <ol>
        <li><strong><?= $worksTrans2 ?>:</strong>
          <p><?= $worksTrans3 ?>: <strong>+34 912 690 123</strong>.<br>Mail: <a href="mailto:soporte@avirato.com?Subject=Codigo%20Web"><strong>soporte@avirato.com</strong></a>.</p>
          <p><?= $worksTrans4 ?></p>
          <p><?= $worksTrans5 ?></p>
        </li>
        <li>
          <strong><?= $worksTrans6 ?>:</strong>
          <p><?= $worksTrans7 ?></p>
        </li>
        <li>
          <strong><?= $worksTrans10 ?>:</strong>
          <ul id="ahop_ul1">
            <li><?= $worksTrans11 ?>:
              <ul id="ahop_ul2">
                <li><?= $worksTrans12 ?></li>
                <li><?= $worksTrans12_1 ?></li>
                <li><?= $worksTrans12_2 ?></li>
                <li><?= $worksTrans12_3 ?></li>
                <li><?= $worksTrans12_4 ?></li>
                <li><?= $worksTrans12_5 ?></li>
              </ul>
            </li>
          </ul>
        </li>

        <p><?= $worksTrans13 ?></p>
        <p><?= $worksTrans14 ?></p>
      </ol>
    </div>
  </div>

<?php
}

function getPromotionPackagesFromDatabase()
{

  global $wpdb;
  $table_name = $wpdb->prefix . 'ahop_textComp_offerPacks';
  $html_bbdd = $wpdb->get_results('SELECT * FROM ' . $table_name . ' ORDER BY ID ', OBJECT)[0];

  return json_decode($html_bbdd->textoCompleto);
}

function getPromotionPackagesSelectorsFromDatabase()
{

  global $wpdb;
  $table_name = $wpdb->prefix . 'ahop_cats_offerPacks';
  $html_bbdd = $wpdb->get_results('SELECT * FROM ' . $table_name . ' WHERE NOT (id_paquetes="0") GROUP BY categoria ORDER BY id', OBJECT);

  return $html_bbdd;
}

function getPromotionPackagesCatFromDatabase()
{

  global $wpdb;
  $table_name = $wpdb->prefix . 'ahop_cats_offerPacks';
  $html_bbdd = $wpdb->get_results('SELECT id, id_paquetes, group_concat(categoria separator "/ ") as categoria, background_color, text_color FROM ' . $table_name . ' WHERE NOT (id_paquetes="0") GROUP BY id_paquetes ORDER BY id', OBJECT);

  return $html_bbdd;
}

function printImagePackage($package)
{
  $toPrint = '';

  foreach ($package->images as $image) {
    $toPrint .= '<div class="swiper-slide"><img class="offerPic" alt="" src="' . $image->url_image . '" ></div>';
    //        break;
  }
  $ahopSwiper = '<div class="swiper-container"><div class="swiper-wrapper">' . $toPrint . '</div> </div>';

  return $ahopSwiper;
}

function printExtrasPackage($package, $color)
{
  if (!empty($package->extras)) {
    foreach ($package->extras as $extra) {
      $toPrint .= "<li style='color:" . $color . "!important'>" . $extra->nombre . ' (' . $extra->cantidad . ")</li>";
    }
    $htmlLang = get_language_attributes('html');
    if (strpos($htmlLang, 'es') !== false) {
      $toPrintF = '<p class="extrasUlP">Extras:</p><ul>' . $toPrint . '</ul>';
    } else if (strpos($htmlLang, 'en') !== false) {
      $toPrintF = '<p class="extrasUlP">Additional features:</p><ul>' . $toPrint . '</ul>';
    } else if (strpos($htmlLang, 'fr') !== false) {
      $toPrintF = '<p class="extrasUlP">Extras:</p><ul>' . $toPrint . '</ul>';
    } else if (strpos($htmlLang, 'de') !== false) {
      $toPrintF = '<p class="extrasUlP">Extras:</p><ul>' . $toPrint . '</ul>';
    } else if (strpos($htmlLang, 'it') !== false) {
      $toPrintF = '<p class="extrasUlP">Extra:</p><ul>' . $toPrint . '</ul>';
    } else if (strpos($htmlLang, 'ru') !== false) {
      $toPrintF = '<p class="extrasUlP">дополнительные услуги:</p><ul>' . $toPrint . '</ul>';
    } else if (strpos($htmlLang, 'pt') !== false) {
      $toPrintF = '<p class="extrasUlP">Extras:</p><ul>' . $toPrint . '</ul>';
    } else if (strpos($htmlLang, 'ca') !== false) {
      $toPrintF = '<p class="extrasUlP">Extres:</p><ul>' . $toPrint . '</ul>';
    }
  } else {
    $toPrintF = "";
  }

  return $toPrintF;
}

function ahop_shortcode_offerPacks()
{
  $otherTrans = __('Other', 'avirato-hotels-promotional-packs');
  $packageSelectors = getPromotionPackagesSelectorsFromDatabase();
  $packages = getPromotionPackagesFromDatabase();
  $caats = getPromotionPackagesCatFromDatabase();
  $toPrint = '';
  $selectors = '<option>All</option>';
  $categoria = '';
  $htmlLang = get_language_attributes('html');
  foreach ($packageSelectors as $selector) {
    $selectors .= '<option>' . $selector->categoria . '</option>';
  }
  foreach ($packages as $package) {
    if (!in_array($package->id, $caats->package_id)) {
      $categoria = '<div class="paCateg">' . $otherTrans . '</div>';
      $background = '';
      $color = '';
    }
    foreach ($caats as $select) {

      if ($package->package_id == $select->id_paquetes) {
        $categoria = '<div class="paCateg">' . $select->categoria . '</div>';
        $background = $select->background_color;
        $color = $select->text_color;
      }
    }

    if (strpos($htmlLang, 'es') !== false) {
      $toPrint .= ''
        . '<div class="item offerBox" style="color:' . $color . '!important">'
        . $categoria
        . '<div class="firstDiv" style="background:' . $background . ';color:' . $color . '!important"><h4 style="color:' . $color . '!important">'
        . $package->nombre_es
        . '</h4>'
        . '<p class="packDate" style="color:' . $color . '!important"><b>' . $package->fecha_entrada . '</b> / <b>' . $package->fecha_salida . '</b></p>'
        . '<p class="more" style="color:' . $color . '!important">' . $package->descripcion_es . '</p>'
        . printExtrasPackage($package, $color)
        . '<a class="bookButton"  href="' . $package->links->self . '" target ="_blank" style="color:' . $color . '!important; border-color:' . $color . '">RESERVAR</a>'
        . '<h4 class="offerPrice" style="color:' . $color . '!important"><span  style="color:' . $color . ' !important">Desde:<br></span><span> ' . $package->precio . '</span> €</h4></div>'
        . '<div class="lastDiv">' . printImagePackage($package) . '</div>'
        . '</div>'
        . '';
    } else if (strpos($htmlLang, 'en') !== false) {
      $toPrint .= ''
        . '<div class="item offerBox" style="color:' . $color . '!important">'
        . $categoria
        . '<div class="firstDiv" style="background:' . $background . ';color:' . $color . '!important"><h4 style="color:' . $color . '!important">'
        . $package->nombre_en
        . '</h4>'
        . '<p class="packDate" style="color:' . $color . '!important"><b>' . $package->fecha_entrada . '</b> / <b>' . $package->fecha_salida . '</b></p>'
        . '<p class="more" style="color:' . $color . '!important">' . $package->descripcion_en . '</p>'
        . printExtrasPackage($package, $color)
        . '<a class="bookButton"  href="' . $package->links->self . '" target ="_blank" style="color:' . $color . '!important; border-color:' . $color . '">BOOK</a>'
        . '<h4 class="offerPrice" style="color:' . $color . '!important"><span  style="color:' . $color . ' !important">From:<br></span><span> ' . $package->precio . '</span> €</h4></div>'
        . '<div class="lastDiv">' . printImagePackage($package) . '</div>'
        . '</div>'
        . '';
    } else if (strpos($htmlLang, 'fr') !== false) {
      $toPrint .= ''
        . '<div class="item offerBox" style="color:' . $color . '!important">'
        . $categoria
        . '<div class="firstDiv" style="background:' . $background . ';color:' . $color . '!important"><h4 style="color:' . $color . '!important">'
        . $package->nombre_fr
        . '</h4>'
        . '<p class="packDate" style="color:' . $color . '!important"><b>' . $package->fecha_entrada . '</b> / <b>' . $package->fecha_salida . '</b></p>'
        . '<p class="more" style="color:' . $color . '!important">' . $package->descripcion_fr . '</p>'
        . printExtrasPackage($package, $color)
        . '<a class="bookButton"  href="' . $package->links->self . '" target ="_blank" style="color:' . $color . '!important; border-color:' . $color . '">RÉSERVE</a>'
        . '<h4 class="offerPrice" style="color:' . $color . '!important"><span  style="color:' . $color . ' !important">De:<br></span><span> ' . $package->precio . '</span> €</h4></div>'
        . '<div class="lastDiv">' . printImagePackage($package) . '</div>'
        . '</div>'
        . '';
    } else if (strpos($htmlLang, 'de') !== false) {
      $toPrint .= ''
        . '<div class="item offerBox" style="color:' . $color . '!important">'
        . $categoria
        . '<div class="firstDiv" style="background:' . $background . ';color:' . $color . '!important"><h4 style="color:' . $color . '!important">'
        . $package->nombre_de
        . '</h4>'
        . '<p class="packDate" style="color:' . $color . '!important"><b>' . $package->fecha_entrada . '</b> / <b>' . $package->fecha_salida . '</b></p>'
        . '<p class="more" style="color:' . $color . '!important">' . $package->descripcion_de . '</p>'
        . printExtrasPackage($package, $color)
        . '<a class="bookButton"  href="' . $package->links->self . '" target ="_blank" style="color:' . $color . '!important; border-color:' . $color . '">RESERVIEREN</a>'
        . '<h4 class="offerPrice" style="color:' . $color . '!important"><span  style="color:' . $color . ' !important">Von:<br></span><span> ' . $package->precio . '</span> €</h4></div>'
        . '<div class="lastDiv">' . printImagePackage($package) . '</div>'
        . '</div>'
        . '';
    } else if (strpos($htmlLang, 'it') !== false) {
      $toPrint .= ''
        . '<div class="item offerBox" style="color:' . $color . '!important">'
        . $categoria
        . '<div class="firstDiv" style="background:' . $background . ';color:' . $color . '!important"><h4 style="color:' . $color . '!important">'
        . $package->nombre_it
        . '</h4>'
        . '<p class="packDate" style="color:' . $color . '!important"><b>' . $package->fecha_entrada . '</b> / <b>' . $package->fecha_salida . '</b></p>'
        . '<p class="more" style="color:' . $color . '!important">' . $package->descripcion_it . '</p>'
        . printExtrasPackage($package, $color)
        . '<a class="bookButton"  href="' . $package->links->self . '" target ="_blank" style="color:' . $color . '!important; border-color:' . $color . '">RISERVA</a>'
        . '<h4 class="offerPrice" style="color:' . $color . '!important"><span  style="color:' . $color . ' !important">Da:<br></span><span> ' . $package->precio . '</span> €</h4></div>'
        . '<div class="lastDiv">' . printImagePackage($package) . '</div>'
        . '</div>'
        . '';
    } else if (strpos($htmlLang, 'ru') !== false) {
      $toPrint .= ''
        . '<div class="item offerBox" style="color:' . $color . '!important">'
        . $categoria
        . '<div class="firstDiv" style="background:' . $background . ';color:' . $color . '!important"><h4 style="color:' . $color . '!important">'
        . $package->nombre_ru
        . '</h4>'
        . '<p class="packDate" style="color:' . $color . '!important"><b>' . $package->fecha_entrada . '</b> / <b>' . $package->fecha_salida . '</b></p>'
        . '<p class="more" style="color:' . $color . '!important">' . $package->descripcion_ru . '</p>'
        . printExtrasPackage($package, $color)
        . '<a class="bookButton"  href="' . $package->links->self . '" target ="_blank" style="color:' . $color . '!important; border-color:' . $color . '">ЗАБРОНИРОВАТЬ</a>'
        . '<h4 class="offerPrice" style="color:' . $color . '!important"><span  style="color:' . $color . ' !important">OT:<br></span><span> ' . $package->precio . '</span> €</h4></div>'
        . '<div class="lastDiv">' . printImagePackage($package) . '</div>'
        . '</div>'
        . '';
    } else if (strpos($htmlLang, 'pt') !== false) {
      $toPrint .= ''
        . '<div class="item offerBox" style="color:' . $color . '!important">'
        . $categoria
        . '<div class="firstDiv" style="background:' . $background . ';color:' . $color . '!important"><h4 style="color:' . $color . '!important">'
        . $package->nombre_pt
        . '</h4>'
        . '<p class="packDate" style="color:' . $color . '!important"><b>' . $package->fecha_entrada . '</b> / <b>' . $package->fecha_salida . '</b></p>'
        . '<p class="more" style="color:' . $color . '!important">' . $package->descripcion_pt . '</p>'
        . printExtrasPackage($package, $color)
        . '<a class="bookButton"  href="' . $package->links->self . '" target ="_blank" style="color:' . $color . '!important; border-color:' . $color . '">LIVRO</a>'
        . '<h4 class="offerPrice" style="color:' . $color . '!important"><span  style="color:' . $color . ' !important">FROM:<br></span><span> ' . $package->precio . '</span> €</h4></div>'
        . '<div class="lastDiv">' . printImagePackage($package) . '</div>'
        . '</div>'
        . '';
    } else if (strpos($htmlLang, 'ca') !== false) {
      $toPrint .= ''
        . '<div class="item offerBox" style="color:' . $color . '!important">'
        . $categoria
        . '<div class="firstDiv" style="background:' . $background . ';color:' . $color . '!important"><h4 style="color:' . $color . '!important">'
        . $package->nombre_cat
        . '</h4>'
        . '<p class="packDate" style="color:' . $color . '!important"><b>' . $package->fecha_entrada . '</b> / <b>' . $package->fecha_salida . '</b></p>'
        . '<p class="more" style="color:' . $color . '!important">' . $package->descripcion_cat . '</p>'
        . printExtrasPackage($package, $color)
        . '<a class="bookButton"  href="' . $package->links->self . '" target ="_blank" style="color:' . $color . '!important; border-color:' . $color . '">RESERVA</a>'
        . '<h4 class="offerPrice" style="color:' . $color . '!important"><span  style="color:' . $color . ' !important">DES:<br></span><span> ' . $package->precio . '</span> €</h4></div>'
        . '<div class="lastDiv">' . printImagePackage($package) . '</div>'
        . '</div>'
        . '';
    }
  }

  $gridContent = '<div id="ahop_dropdown"><select>' . $selectors . '<option>' . $otherTrans . '</option></select></div><div class="masonry">' . $toPrint . '</div>'
    . '<script>'
    . 'jQuery(".morelink").click(function () {'
    . 'debugger;'
    . 'var elementHeights = jQuery(".item.offerBox").map(function () {'
    . 'return jQuery(this).height();'
    . '}).get();'
    . 'var maxHeight = Math.max.apply(null, elementHeights);'
    . 'jQuery(".item.offerBox").height(maxHeight);'
    . ' jQuery(".firstDiv").height(maxHeight);'
    . '}); '
    . '</script>';
  return $gridContent;
}
add_action('init', 'ahop_textdomain');
function ahop_addDnsHead()
{
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-core');

  //wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_style('jquery-ui-css', plugins_url('includes/css/smoothness/jquery-ui.css', __FILE__));
  if (is_page('paquetes-promocionales')) {
    wp_enqueue_style('swiperCssMin', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css');
    wp_enqueue_script('swiperMinjs', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js', array(), null, true);
    wp_enqueue_script('ahop_js_inline', plugins_url('includes/js/ahop_js_inline.js', __FILE__));
    wp_enqueue_style('ahop_packs_css', plugins_url('includes/css/ahop_packs_css.css', __FILE__));
  }
}

function ahop_admin_style()
{
  wp_enqueue_style('ahop_admin_styleCss', plugins_url('includes/css/ahop_admin_stylecss.css', __FILE__));
  wp_enqueue_script('ahop_tabs_script', plugins_url('includes/js/ahop_tabs_script.js', __FILE__));
}


register_activation_hook(__FILE__, 'ahop_create_tables');
PostCreator('Paquetes Promocionales', 'page');
register_deactivation_hook(__FILE__, 'ahop_remove_tables');
add_action('admin_menu', 'ahop_aviratoOfferPacks_plugin_menu_admin');


add_action('admin_enqueue_scripts', 'ahop_AjaxConn_Enq');


add_action('wp_ajax_ahop_AjaxConnOP', 'ahop_AjaxConnOP');
add_action('wp_ajax_ahop_AjaxMulti', 'ahop_AjaxMulti');
add_shortcode('Avirato_paquetes', 'ahop_shortcode_offerPacks');
add_action('admin_enqueue_scripts', 'ahop_admin_style');
//add_action('admin_init', 'ahop_aviratoCalendar_content_settings');
add_action('wp_head', 'ahop_addDnsHead');
