<?php
  $page_title = 'Lista de productos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
?>
<?php include_once('layouts/header.php'); ?>
<?php $all_categories = find_all('categories'); ?>
<?php
  if (isset($_POST["search_product"])) {
    $busqueda = remove_junk($db->escape($_POST['buscar']));
    $category = remove_junk($db->escape($_POST['category']));
    if($busqueda != ''){
      echo "Buscando: " . $busqueda;
    }
    $products = find_product_containing_string($busqueda, $category);
  }

?>



  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_product.php" class="btn btn-success">Agregar producto</a>
         </div>

         <div class="pull-left">
           <form class="search" action="product.php" method="post">

             <i class="glyphicon glyphicon glyphicon-search"></i> <input type="text" name="buscar" value="" placeholder="Buscar">

             <select class="form-control" name="category">
               <option value=""></option>
               <?php  foreach ($all_categories as $cat): ?>
                 <option value="<?php echo $cat['name'] ?>">
                   <?php echo $cat['name'] ?></option>
               <?php endforeach; ?>
             </select>

             <button type="submit" name="search_product" class="btn btn-info">Buscar</button>

           </form>
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
             <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
