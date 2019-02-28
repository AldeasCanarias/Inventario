<?php
  $page_title = 'Editar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_product_by_id((int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
$all_states = find_all('state');
$all_locations = find_all('location');
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saling-price','state','code' ,'location');
    validate_fields($req_fields);

   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_buy   = remove_junk($db->escape($_POST['buying-price']));
     $p_sale = remove_junk($db->escape($_POST['saleing-price']));
     $p_state  = remove_junk($db->escape($_POST['state']));
     $p_code  = remove_junk($db->escape($_POST['code']));
     $p_location  = remove_junk($db->escape($_POST['location']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
       $query   = "UPDATE products SET";
       $query  .=" name ='{$p_name}', quantity ='{$p_qty}',";
       $query  .=" buy_price ='{$p_buy}', sale_price ='{$p_sale}', categorie_id ='{$p_cat}',media_id='{$media_id}',";
       $query  .=" state_id='{$p_state}',code='{$p_code}', location_id='{$p_location}'";
       $query  .=" WHERE id ='{$product['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Producto ha sido actualizado. ");
                 redirect('product.php', false);
               } else {
                 $session->msg('d',' Lo siento, actualización falló.');
                 redirect('edit_product.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_product.php?id='.$product['id'], false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Editar producto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']);?>">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                      <option value="">Selecciona una categoría</option>
                       <?php  foreach ($all_categories as $cat): ?>
                         <option value="<?php echo (int)$cat['id']; ?>" <?php if($product['categorie'] === $cat['name']): echo "selected"; endif; ?> >
                           <?php echo remove_junk($cat['name']); ?></option>
                       <?php endforeach; ?>
                    </select>
                  </div>
                  <!--<div class="col-md-6">
                    <select class="form-control" name="product-photo">
                      <option value=""> Sin imagen</option>
                      <?php  foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id'];?>" <?php if($product['media_id'] === $photo['id']): echo "selected"; endif; ?> >
                          <?php echo $photo['file_name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>-->
                </div>
              </div>
<!-- Creamos adaptacion en particular añadir codigo y estado -->
        <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="qty">Código</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon glyphicon-qrcode"></i>
                  </span>
                  <input type="text" class="form-control" name="code" value="<?php echo remove_junk($product['code']); ?>">
               </div>
              </div>
              <div class="col-md-6">
                <label for="qty"> Estado</label>
                <select class="form-control" name="state">
                  <option value="">Estado</option>
                   <?php  foreach ($all_states as $sta): ?>
                     <option value="<?php echo (int)$sta['id']; ?>" <?php if($product['state'] === $sta['state_name']): echo "selected"; endif; ?> >
                       <?php echo remove_junk($sta['state_name']); ?></option>
                   <?php endforeach; ?>
                </select>
               </div>
              </div>
            </div>
            </div>


<!-- Adaptacion terminada -->
              <div class="form-group">
               <div class="row">
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="qty">Cantidad</label>
                    <div class="input-group">
                      <span class="input-group-addon">
                       <i class="glyphicon glyphicon-shopping-cart"></i>
                      </span>
                      <input type="number" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>">
                   </div>
                  </div>
                 </div>

                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="qty">Ubicación del producto</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         <i class="glyphicon glyphicon-map-marker"></i>
                       </span>
                       <select class="form-control" name="location">
                         <option value=""></option>
                          <?php  foreach ($all_locations as $loc): ?>
                            <option value="<?php echo (int)$loc['id']; ?>" <?php if($product['location'] === $loc['location_name']): echo "selected"; endif; ?> >
                              <?php echo remove_junk($loc['location_name']); ?></option>
                          <?php endforeach; ?>
                       </select>
                       <input type="hidden" name="saling-price" value="0">
                       <input type="hidden" name="saleing-price" value="0">
                       <input type="hidden" name="buying-price" value="0">
                    </div>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="product" class="btn btn-danger">Actualizar</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
