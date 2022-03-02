<h1>EU DISCLAIMER</h1> <br>
<h2>Configuration</h2>

<?php
/* add_action('init', 'traitement_des_donnees');
    function traitement_des_donnees(){
        if ((isset($_POST['message_disclaimer'])) && (wp_verify_nonce($_POST['message_disclaimer'], 'le_message'))) { */
// Le formulaire est validé et sécurisé, suite du traitement
if (!empty($_POST['message_disclaimer'])) {
    $message_disclaimer_new = $_POST['message_disclaimer'];
    update_option('message_disclaimer', $message_disclaimer_new);
    echo '<strong style="color:green; font-size:16px;">Les données ont correctement été mises à jour !</strong>';
}
// }
// }
?>

<form method="post" action="" novalidate="novalidate">
    <table class="form-table">
        <tr>
            <?php // wp_nonce_field('le_message', 'message_disclaimer'); 
            ?>
            <th scope="row"><label for="blogname">Message du disclaimer</label></th>
            <td><input name="message_disclaimer" type="text" id="message_disclaimer" value="" class="regular-text" /></td>
        </tr>
    </table>
    <?php submit_button(); ?>
</form> <br>
<p>La législation nous impose de vous informer sur la nocivité des produits à base de nicotine, vous devez avoir plus de 18 ans pour consulter ce site !</p> <br>
<h3> Centre AFPA / session DWWM </h3>
<img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/img/layout_set_logo.png'; ?>" width="20%">