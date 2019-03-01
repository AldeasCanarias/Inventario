<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $product = find_by_id('products',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","ID vacío");
    redirect('product.php');
  }
?>
<?php
  //1. Borrar imagen de directorio
  $productPath = SITE_ROOT.DS.'..'.DS.'uploads/products/';
  $image = find_media_by_id($product['media_id']);
  //unlink($productPath.$image);
  $photo = new Media();
  $photo->media_destroy($image['id'], $image['file_name']);
  //2. Borrar imagen de la base de datos
  //$delete_img = delete_by_id('media', (int)$product['media_id']);
  //3. Borrar producto
  $delete_id = delete_by_id('products', (int)$product['id']);
  if($delete_id){
      $session->msg("s","Producto eliminado");
      redirect('product.php');
  } else {
      $session->msg("d","Eliminación falló");
      redirect('product.php');
  }
?>
