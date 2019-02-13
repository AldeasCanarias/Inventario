<?php
error_reporting(0);
  $page_title = 'Productos ordenados';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
  $all_categories = find_all('categories');

  if ($_POST["categorie-title"] != '' ){
    $categorie=$_POST["categorie-title"];

  }else{
    $categorie ='';
  }
  if ($_POST["location-title"] != '' ){
    $location=$_POST["location-title"];;

  }else{
    $location ='';
  }

   $all_location  = find_all('location');


?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h3> Criterios de ordenación. </h3>
          <div class="pull-left">

            <form method="post" action="sort_product.php" class="clearfix" method="post">
                <div class="form-group">
                  <div class="input-group">
                      <!-- <input type="text" class="form-control" name="categorie-title" placeholder="Categoria"> -->
                      <select class="form-control" name="categorie-title">
                        <option value="">Selecciona una categoría</option>
                      <?php  foreach ($all_categories as $cat): ?>
                        <option value="<?php echo $cat['name'] ?>">
                          <?php echo $cat['name'] ?></option>
                      <?php endforeach; ?>
                      </select>
                      <select class="form-control" name="location-title">
                        <option value="">Selecciona una localización</option>
                      <?php  foreach ($all_location as $prot): ?>
                        <option value="<?php echo $prot['location'] ?>">
                          <?php echo $prot['location'] ?></option>
                      <?php endforeach; ?>
                      </select>
                      <button type="submit" name="sort_product" class="btn btn-danger">Ordenar</button>
            </form>

                 </div>
                </div>

          </div>
         <div class="pull-right">
           <!-- Espacio vacio para cuadrar contenido -->
          </div>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> Imagen</th>
                <th class="text-center" style="width: 10%;"> Código </th>
                <th> Descripción </th>
                <th class="text-center" style="width: 10%;"> Categoría </th>
                <th class="text-center" style="width: 10%;"> Stock </th>
                <th class="text-center" style="width: 10%;"> Precio de compra </th>
                <th class="text-center" style="width: 10%;">Estado </th>
                <th class="text-center" style="width: 10%;">Ubicación </th>
                <th class="text-center" style="width: 10%;"> Agregado </th>
                <th class="text-center" style="width: 100px;"> Acciones </th>
              </tr>
            </thead>
            <tbody>
              <?php
              // print_r ($products);

              foreach ($products as $product):?>
              <!-- Mostar en caso que solo indiquemos la categoria -->
              <?php if($product['categorie']!= '' AND $product['categorie']==$categorie):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td>
                  <?php if($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                  <?php else: ?>
                  <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
                </td>
                <td class="text-center"> <?php echo remove_junk($product['code']); ?></td>
                <td>

                   <?php echo remove_junk($product['name']); ?>
                 </td>
                <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>

                <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['state']); ?></td>
                <td class="text-center"> <?php echo remove_junk($product['location']); ?></td>
                <td class="text-center"> <?php echo read_date($product['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                     <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>

          <!-- Mostar en caso que solo indiquemos la localizacion -->
          <?php elseif( $product['location']!='' AND $product['location']==$location):?>
            <tr>
              <td class="text-center"><?php echo count_id();?></td>
              <td>
                <?php if($product['media_id'] === '0'): ?>
                  <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                <?php else: ?>
                <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
              <?php endif; ?>
              </td>
              <td class="text-center"> <?php echo remove_junk($product['code']); ?></td>
              <td>

                 <?php echo remove_junk($product['name']); ?>
               </td>
              <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
              <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>

              <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
              <td class="text-center"> <?php echo remove_junk($product['state']); ?></td>
              <td class="text-center"> <?php echo remove_junk($product['location']); ?></td>
              <td class="text-center"> <?php echo read_date($product['date']); ?></td>
              <td class="text-center">
                <div class="btn-group">
                  <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                    <span class="glyphicon glyphicon-edit"></span>
                  </a>
                   <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                </div>
              </td>
            </tr>


          <!-- Mostar en caso indiquemos la categoria y la localizacion -->
          <?php elseif( $product['location']!='' AND $product['location']!='' and $product['location']==$location or $product['categorie']==$categorie):?>
            <tr>
              <td class="text-center"><?php echo count_id();?></td>
              <td>
                <?php if($product['media_id'] === '0'): ?>
                  <img class="img-avatar img-circle" src="uploads/products/no_image.jpg" alt="">
                <?php else: ?>
                <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
              <?php endif; ?>
              </td>
              <td class="text-center"> <?php echo remove_junk($product['code']); ?></td>
              <td>

                 <?php echo remove_junk($product['name']); ?>
               </td>
              <td class="text-center"> <?php echo remove_junk($product['categorie']); ?></td>
              <td class="text-center"> <?php echo remove_junk($product['quantity']); ?></td>

              <td class="text-center"> <?php echo remove_junk($product['buy_price']); ?></td>
              <td class="text-center"> <?php echo remove_junk($product['state']); ?></td>
              <td class="text-center"> <?php echo remove_junk($product['location']); ?></td>
              <td class="text-center"> <?php echo read_date($product['date']); ?></td>
              <td class="text-center">
                <div class="btn-group">
                  <a href="edit_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                    <span class="glyphicon glyphicon-edit"></span>
                  </a>
                   <a href="delete_product.php?id=<?php echo (int)$product['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                </div>
              </td>
            </tr>

          <?php endif; ?>
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
