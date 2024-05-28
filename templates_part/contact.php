<?php
/*
 Template Name: Contact
*/

wp_head();
?>
<!-- Fenêtre modale -->
<div class="modal">
  <!-- Contenu de la modale -->
  <div class="modal__content">
    <!-- Formulaire de contact -->
	  <?php echo apply_shortcodes('[contact-form-7 id="53ed111" title="Contact" html_id="contact" html_class="contact"]'); ?>
  </div>
</div>
