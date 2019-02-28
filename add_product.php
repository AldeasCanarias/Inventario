<?php
  $page_title = 'Agregar producto';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
  $all_location =find_all('location');
  $all_state =find_all('state');
?>
<?php
 if(isset($_POST['add_product'])){
   $req_fields = array('product-title','product-categorie','product-quantity','buying-price', 'saling-price','state','code' ,'location');
   validate_fields($req_fields);
   if(empty($errors)){
     $p_name  = remove_junk($db->escape($_POST['product-title']));
     $p_cat   = remove_junk($db->escape($_POST['product-categorie']));
     $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $p_buy   = remove_junk($db->escape($_POST['buying-price']));
     $p_sale = remove_junk($db->escape($_POST['saling-price']));
     $p_state  = remove_junk($db->escape($_POST['state']));
     $p_code  = remove_junk($db->escape($_POST['code']));
     $p_location  = remove_junk($db->escape($_POST['location']));
     //if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {

      $photo = new Media();
      $error_subida = $photo->upload($_FILES['file_upload']); //<- FALLA AQUI
      $img_id = $photo->process_media();
      if($img_id != false){
        $session->msg('s','Imagen subida al servidor.');
        $media_id = $img_id;
      } else{
        $session->msg('d',join($photo->errors));
        $media_id = $error_subida;
        $img_id = "Error de insercion";
      }


     if ($p_buy ==''){
       $p_buy = 0;
     }
     $date    = make_date();
     $query  = "INSERT INTO products (";
     $query .=" name,quantity,buy_price,sale_price,categorie_id,media_id,date,state_id,code,location_id";
     $query .=") VALUES (";
     $query .=" '{$p_name}', '{$p_qty}', '{$p_buy}', '{$p_sale}' ,'{$p_cat}', '{$media_id}', '{$date}', '{$p_state}', '{$p_code}', '{$p_location}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$p_name}'";
     if($db->query($query)){
       $session->msg('s',"Producto agregado exitosamente. ");
       redirect('add_product.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('product.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_product.php',false);
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
  <div class="col-md-9">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Agregar producto</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_product.php" class="clearfix" enctype="multipart/form-data">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="product-title" placeholder="Descripción">
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <select class="form-control" name="product-categorie">
                      <option value="">Selecciona una categoría</option>
                    <?php  foreach ($all_categories as $cat): ?>
                      <option value="<?php echo (int)$cat['id'] ?>">
                        <?php echo $cat['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <span>Imagen</span>
                    <span class="input-group-btn">
                      <input type="file" name="file_upload" class="form-control"/>
                   </span>
                  </div>
                </div>
              </div>

<!-- Creamos adaptacion en particular añadir codigo y estado -->
        <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon glyphicon-qrcode"></i>
                  </span>
                  <input type="text" class="form-control" name="code" placeholder="Código de producto">
                  <input type="hidden" name="saling-price" value="0">
                  <input type="hidden" name="buying-price" value="0">
               </div>
              </div>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon glyphicon-flag"></i>
                  </span>
                  <select class="form-control" name="state">
                    <option value="">Estado</option>
                  <?php  foreach ($all_state as $sta): ?>
                    <option value="<?php echo $sta['id'] ?>">
                      <?php echo $sta['state_name'] ?></option>
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
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="Cantidad">
                  </div>
                 </div>

                 <!--Adaptacion con la localicacion del Producto  -->
                  <div class="col-md-4">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <i class="glyphicon glyphicon-home"></i>
                      </span>
                      <select class="form-control" name="location">
                        <option value="">Selecciona una ubicación</option>
                      <?php  foreach ($all_location as $cat): ?>
                        <option value="<?php echo $cat['id'] ?>">
                          <?php echo $cat['location_name'] ?></option>
                      <?php endforeach; ?>
                      </select>
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="add_product" class="btn btn-danger">Agregar producto</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
