<?php if (!isset($redirect)) { ?>
<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <td class="text-left"><?php echo $column_name; ?></td>
        <td class="text-left"><?php echo $column_model; ?></td>
        <td class="text-right"><?php echo $column_quantity; ?></td>
        <td class="text-right"><?php echo $column_price; ?></td>
        <td class="text-right"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?>
          <?php if($product['recurring']) { ?>
          <br />
          <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
          <?php } ?></td>
        <td class="text-left"><?php echo $product['model']; ?></td>
        <td class="text-right"><?php echo $product['quantity']; ?></td>
        <td class="text-right"><?php echo $product['price']; ?></td>
        <td class="text-right"><?php echo $product['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="text-left"><?php echo $voucher['description']; ?></td>
        <td class="text-left"></td>
        <td class="text-right">1</td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
        <td class="text-right"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td colspan="4" class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
        <td class="text-right"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<?php echo $payment; ?>
<?php } else { ?>
<script type="text/javascript"><!--
location = '<?php echo $redirect; ?>';
//--></script>
<div class="form-group">
    <label for="np_city">Город Новой Почты</label>
    <select id="np_city" name="np_city" class="form-control">
        <option value="">Выберите город</option>
        <!-- Города будут загружаться сюда -->
    </select>
</div>

<div class="form-group">
    <label for="np_warehouse">Отделение Новой Почты</label>
    <select id="np_warehouse" name="np_warehouse" class="form-control">
        <option value="">Выберите отделение</option>
        <!-- Отделения будут загружаться сюда -->
    </select>
</div>

<script type="text/javascript">
    // Загружаем города при загрузке страницы
    $(document).ready(function() {
        $.ajax({
            url: 'index.php?route=shipping/novaposhta/getCities',
            method: 'GET',
            success: function(response) {
                var cities = JSON.parse(response);  // Преобразуем ответ в объект
                var citySelect = $('#np_city');
                
                // Заполняем выпадающий список городов
                citySelect.empty();  // Очистим текущие значения
                cities.forEach(function(city) {
                    citySelect.append('<option value="' + city.city_id + '">' + city.name + '</option>');
                });
            }
        });

        // Когда выбран город, загружаем соответствующие отделения
        $('#np_city').change(function() {
            var city_id = $(this).val();
            
            $.ajax({
                url: 'index.php?route=shipping/novaposhta/getWarehouses&city_id=' + city_id,
                method: 'GET',
                success: function(response) {
                    var warehouses = JSON.parse(response);
                    var warehouseSelect = $('#np_warehouse');
                    
                    // Заполняем выпадающий список отделений
                    warehouseSelect.empty();
                    warehouses.forEach(function(warehouse) {
                        warehouseSelect.append('<option value="' + warehouse.warehouse_id + '">' + warehouse.name + '</option>');
                    });
                }
            });
        });
    });
</script>
<?php } ?>
