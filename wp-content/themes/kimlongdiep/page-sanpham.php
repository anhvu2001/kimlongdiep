<?php

/*
Template Name: Trang sản phẩm
*/
get_header();


?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; ?>
<?php endif; ?>
<div class="main-content">
  <div class="category_page">
    <div class="product_category_header">
      <div class="breadcrumb"></div>
    </div>
    <div id="primary" class="content-area">
      <div class="sidebar_filter_product">
        <h4 style="color:white">Bộ lọc tìm kiếm</h4>
        <div class="filter_product">
          <div class="product_attribute_title">Sản phẩm</div>
          <?php
          $categories = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false, // Nếu muốn lấy cả các danh mục không có sản phẩm, đặt 'true' (mặc định là 'false').
          ) );
          ?>
          <div class="filter_group_product_options">

            <?php
            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
              foreach ( $categories as $category ) {
                if($category->name == 'Chưa phân loại'){
                  continue;
                }
                echo "<div class=\"filter_product_option\">
                        <label class=\"product_attribute_option\"><label>
                          <input name=\"category_name\" class=\"filter_product_option_input\" type=\"checkbox\" value=\"".$category->term_id."\">$category->name</label>
                        </label>
                      </div>";
              }
            }
            ?>
            <hr class="hr_filter_product">
          </div>
        </div>
        <div class="filter_product">
          <div class="product_attribute_title">Thương hiệu</div>
          <div class="filter_group_product_options">
            <div class="filter_product_option">
              <label class="product_attribute_option"><label>
                <input class="filter_product_option_input attibutes_select" type="checkbox" value="PATHUONGHIEU--Kim Long Diệp">Kim Long Diệp</label>
              </label>
            </div>
            <div class="filter_product_option">
              <label class="product_attribute_option"><label>
                <input class="filter_product_option_input attibutes_select" type="checkbox" value="PATHUONGHIEU--Chanel">Chanel</label>
              </label>
            </div>
            <div class="filter_product_option">
              <label class="product_attribute_option"><label>
                <input class="filter_product_option_input attibutes_select" type="checkbox" value="PATHUONGHIEU--Hermes">Hermes</label>
              </label>
            </div>
            <div class="filter_product_option">
              <label class="product_attribute_option"><label>
                <input class="filter_product_option_input attibutes_select" type="checkbox" value="PATHUONGHIEU--Louis Vuitton">Louis Vuitton</label>
              </label>
            </div>
          </div>
        </div>
        <hr class="hr_filter_product">

        <div class="filter_product">
          <div class="product_attribute_title">Khoảng Giá</div>
          <div class="">
            <div class="range-price">
              <input id="input-with-keypress-0" type="text">
              <span> - </span>
              <input id="input-with-keypress-1" type="text" >
            </div>
            <div class="filter_group_product_options ">
              <div id="steps-slider" class="slider-styled"></div>
            </div>
          </div>
        </div>
        <hr class="hr_filter_product">
        <div class="filter_product">
          <div class="product_attribute_title">Màu sắc vàng</div>
          <div class="filter_group_product_options">
            <div class="filter_product_option">
              <label class="product_attribute_option"><label>
                <input class="filter_product_option_input attibutes_select" type="checkbox" value="PAMAUSACVANG--Trắng">Trắng</label>
              </label>
            </div>
            <div class="filter_product_option">
              <label class="product_attribute_option"><label>
                <input class="filter_product_option_input attibutes_select" type="checkbox" value="PAMAUSACVANG--Vàng">Vàng</label>
              </label>
            </div>
          </div>
        </div>
        <hr class="hr_filter_product">
        <button class="button_submit_fillter">Áp dụng</button>
      </div>
      <main id="main" class="list_product_content" role="main">
        <div class="top_filter">
          <span style="color: var(--d-9-d-9-d-9, #B5B5B5);margin-top:10px">Sắp xếp theo</span>
          <button onclick="" class="filter_moinhat button_active">Mới nhất</button>
          <!-- <button onclick="onclickFilterButton('phobien')" class="filter_phobien ">Phổ biến</button> -->
          <button onclick="" class="filter_banchay">Bán chạy</button>
          <select name="" id="filter_gia">
            <option value="0" disable>Chọn giá</option>
            <option value="1000000--5000000">1.000.000 -- 5.000.000</option>
            <option value="3000000--10000000">3.000.000 -- 10.000.000</option>
            <option value="10000000--20000000">10.000.000 -- 20.000.000</option>
            <option value="20000000--30000000">20.000.000 -- 30.000.000</option>
          </select>
        </div>
        <div id="data-list-product"></div>
        <div id="pagination"></div>
      </main>
    </div>
  </div>
</div>
<script defer>
  /**Render lần đầu tiên */
  // Gán giá trị mặc định cho các fillter và order
  document.addEventListener("DOMContentLoaded", function() {
    let fillters = '';
    let orderQuery = `orderby: {
                field: DATE, order: DESC
              },`;
    getAndRender(12,null,fillters,0,0,null,orderQuery);
  });
  
</script>
<script>
  
  // Xử lý thanh trượt giá
let stepsSlider = document.getElementById('steps-slider');
let input0 = document.getElementById('input-with-keypress-0');
let input1 = document.getElementById('input-with-keypress-1');
let inputs = [input0, input1];

noUiSlider.create(stepsSlider, {
    start: [1000000, 60000000],
    step:500000,
    connect: true,
    format: {
        to: function (value) {
            return value.toLocaleString();
           
        },
        from: function (minValue) {
            return minValue.toLocaleString();
        }
    },
    range: {
        'min': [1000000],
        'max': [60000000]
    }
});

stepsSlider.noUiSlider.on('update', function (values, handle) {
    inputs[handle].value = values[handle];
});
  
</script>

<?php
get_footer();
?>