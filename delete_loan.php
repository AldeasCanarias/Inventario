<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $product = find_by_id('products_loan',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","ID vacío");
    redirect('loan.php');
  }
?>
<?php
  $delete_id = delete_by_id('products_loan',(int)$product['id']);
  if($delete_id){
      $session->msg("s","Producto eliminado");
      redirect('loan.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('loan.php');
  }
?>
