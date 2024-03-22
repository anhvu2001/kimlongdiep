<?php
global $product;
$product_attributes = $product->get_attributes();
if (!empty($product_attributes)) {
?>
    <hr style="border: 1px solid #5C5C5C;margin: 20px 0">
    <div class="product-attributes" style="width: 100%; display: flex; flex-wrap: wrap; gap:5px">
        <?php
        foreach ($product_attributes as $attribute) {
            $attribute_label = wc_attribute_label($attribute->get_name());

            if ($attribute->is_taxonomy()) {
                $attribute_terms = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names'));
                if (!empty($attribute_terms)) {
                    $formatted_terms = array_map('ucfirst', $attribute_terms);
        ?>
                    <div class="product-attributes-item">
                        <span style="font-family: 'Montserrat'; font-style: normal; font-weight: 600; font-size: 14px; line-height: 17px; color: #FFFFFF;"><?php echo esc_html($attribute_label . ': '); ?></span><?php echo esc_html(implode(', ', $formatted_terms)); ?>
                    </div>
                <?php
                }
            } else {
                $attribute_value = $attribute->get_options();
                if (!empty($attribute_value)) {
                    if ($attribute_label === 'Đơn giá') {
                        $formatted_attribute_value = array_map(function ($value) {
                            return number_format((float) preg_replace('/[^0-9,]/', '', $value), 0, ',', '.');
                        }, $attribute_value);
                    } else {
                        $formatted_attribute_value = array_map('ucfirst', $attribute_value);
                    }                ?>
                    <div class="product-attributes-item">
                        <span style="font-family: 'Montserrat'; font-style: normal; font-weight: 600; font-size: 14px; line-height: 17px; color: #FFFFFF;"><?php echo esc_html($attribute_label . ': '); ?></span><?php echo esc_html(implode(', ', $formatted_attribute_value)); ?>
                    </div>
        <?php
                }
            }
        }
        ?>
    </div>
    <hr style="border: 1px solid #5C5C5C;margin: 20px 0">
<?php
}
?>