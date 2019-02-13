<?php
//error_reporting(0);
  $page_title = 'Reservar';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $products = join_product_table();
  $all_categories = find_all('categories');
  $loands = find_all('products_loan');

?>
<?php
print "adios";
 if(isset($_POST['product_loan'])){
   print "Hola";
   print "holA";
   $req_fields = array('name_product','start_date','end_date','person');
   validate_fields($req_fields);
   if(empty($errors)){
     $name_product  = remove_junk($db->escape($_POST['name_product']));
     $start_date   = remove_junk($db->escape($_POST['start_date']));
     $end_date  = remove_junk($db->escape($_POST['end_date']));
     $person  = remove_junk($db->escape($_POST['person']));

     $query  = "INSERT INTO products_loan (";
     $query .=" name_product,start_date,end_date,person";
     $query .=") VALUES (";
     $query .=" '{$name_product}', '{$start_date}', '{$end_date}', '{$person}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name_product='{$name_product}'";
     if($db->query($query)){
       $session->msg('s',"Producto agregado exitosamente. ");
       redirect('loan.php', false);
     } else {
       $session->msg('d',' Lo siento, registro falló.');
       redirect('loan.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('loan.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <h3> Prestamos. </h3>
          <div class="pull-left">

            <form method="post" action="./loan.php" class="clearfix" method="post">
                <div class="form-group">
                  <div class="input-group">
                      <!-- <input type="text" class="form-control" name="categorie-title" placeholder="Categoria"> -->
                      <select class="form-control" name="name_product">
                        <option value="">Selecciona un producto</option>
                      <?php  foreach ($products as $prot): ?>
                        <option value="<?php echo $prot['name'] ?>">
                          <?php echo $prot['name'] ?></option>
                      <?php endforeach; ?>
                      </select>
                      <i> Fecha inicio</i>
                      <input type="datetime-local" name="start_date" step="1" value="<?php echo date("Y-m-d,g:i");?>">
                      <i> Fecha Fin</i>
                      <input type="datetime-local" name="end_date" step="1" value="<?php echo date("Y-m-d,g:i");?>"></br>
                      <input type="text" name="person" placeholder="Persona">
                      <button type="submit" name="product_loan" class="btn btn-danger">Reservar</button>
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
                <th class="text-center"> Código del producto</th>
                <th class="text-center"> Fecha Inicio</th>
                <th class="text-center"> Fecha fin</th>
                <th class="text-center"> Persona</th>
                <th class="text-center"> ¿Finalizada? </th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($loands as $loand):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td class="text-center"> <?php echo remove_junk($loand['name_product']); ?></td>
                <td class="text-center"> <?php echo remove_junk($loand['start_date']); ?></td>
                <td class="text-center"> <?php echo remove_junk($loand['end_date']); ?></td>
                <td class="text-center"> <?php echo remove_junk($loand['person']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                     <a href="delete_loan.php?id=<?php echo (int)$loand['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
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
