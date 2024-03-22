<?php

get_header();
?>


<div class="main-content">
	<div class="category_page">
		<div class="product_category_header">
			<div class="breadcrumb"></div>
			<?php
			// GEt header image of this category
			$slug = get_queried_object()->slug;
			switch ($slug) {
				case 'nhan':
					$img_url = 'https://kimlongdiep.com/wp-content/uploads/2023/06/nhanvangy.png';
					$alt = 'nhan';
					break;
				case 'lac-vong-tay':
					$img_url = 'https://kimlongdiep.com/wp-content/uploads/2023/06/vongtay.png';
					$alt = 'Lắc vòng tay';
					break;
				case 'day-chuyen':
					$img_url = 'https://kimlongdiep.com/wp-content/uploads/2023/06/daychuyen.png';
					$alt = 'Dây chuyền';
					break;
				case 'bong-tai':
					$img_url = 'https://kimlongdiep.com/wp-content/uploads/2023/06/bongtai.png';
					$alt = 'Bông tai';
					break;
				case 'kim-cuong-thien-nhien':
					$img_url = 'https://kimlongdiep.com/wp-content/uploads/2023/11/banner-kim-cuong-thien-nhien-jpg.webp';
					$alt = 'Hột moissanite';
					break;
				case 'mat-day-chuyen':
					$img_url = 'https://kimlongdiep.com/wp-content/uploads/2023/06/matdaychuyen.png';
					$alt = 'Mặt dây chuyền';
					break;
				default:
					$img_url = 'https://kimlongdiep.com/wp-content/uploads/2023/06/nhanvangy.png';
					$alt = 'Nhẫn vàng y';
					break;
			}

			?>
			<img src="<?php echo $img_url ?>" alt="<?php echo $alt ?>">
		</div>
		<div id="primary" class="content-area">
			<div class="sidebar_filter_product">
            	<h1 style="display: none;"><?php echo get_queried_object()->name; ?></h1>
				<p style="color:white;font-size: 24px;margin: 5px 0">Bộ lọc tìm kiếm</p>
				 <?php
        if ($slug != "kim-cuong-thien-nhien") {
        ?>
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
        <?php
        }
        ?>
				<hr class="hr_filter_product">

				<div class="filter_product">
					<div class="product_attribute_title">Khoảng Giá</div>
					<div class="">
						<div class="range-price">
							<input id="input-with-keypress-0" type="text">
							<span> - </span>
							<input id="input-with-keypress-1" type="text">
						</div>
						<div class="filter_group_product_options ">
							<div id="steps-slider" class="slider-styled"></div>
						</div>
					</div>
				</div>
				<hr class="hr_filter_product">
                         <?php
                if ($slug != "kim-cuong-thien-nhien") {
                ?>
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
                    <hr class="hr_filter_product">
                  </div>
                <?php
                }
                ?>
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
				<div class="category-post-wrapper">
					<?php
					$produt_cate_id = get_queried_object()->term_id;
					$args = array(
						'post_type' => 'categrory_post',
						'posts_per_page' => 1,
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'field' => 'term_id',
								'terms' => array($produt_cate_id),
								'operator' => 'IN',
							),
						),
						'orderby' => 'date',
						'order' => 'DESC',
					);
					$query = new WP_Query($args);

					if ($query->have_posts()) {
					?>
						<div class="category-post-content hidden">
                          <?php
                          while ($query->have_posts()) {
                            $query->the_post();
                            the_content();  
                          }
                          	?>
						</div>
						<div class="category-post-content__expanse hidden">
							<button>
								<i class="fa-solid fa-chevron-up"></i>
							</button>
						</div>
					<?php
						wp_reset_postdata();
					} else {
						echo "Không có bài viết danh mục.";
					}
					?>
				</div>
			</main>

		</div>

	</div>

</div>

<script defer>
	const cateContent = document.querySelector('.category-post-content');
	if (cateContent) {
		const expanseBtnWrapper = document.querySelector('.category-post-content__expanse');
		const expanseBtn = document.querySelector('.category-post-content__expanse button');
		if (cateContent.offsetHeight < 183) {
			expanseBtn.style.display = "none";
		}
		if (cateContent.offsetHeight < 10) {
			cateContent.style.display = "none";
		}
		expanseBtn.onclick = function() {
			cateContent.classList.toggle("hidden");
			if (expanseBtnWrapper.classList.contains("hidden")) {
				expanseBtnWrapper.classList.remove("hidden");
				expanseBtnWrapper.classList.add("show");
			} else {
				expanseBtnWrapper.classList.add("hidden");
				expanseBtnWrapper.classList.remove("show");
			}
		}
	} else {
		const cateContentWrapper = document.querySelector('.category-post-wrapper');
		cateContentWrapper.style.display = "none";
	}
	// Xử lý thanh trượt giá
	let stepsSlider = document.getElementById('steps-slider');
	let input0 = document.getElementById('input-with-keypress-0');
	let input1 = document.getElementById('input-with-keypress-1');
	let inputs = [input0, input1];

	noUiSlider.create(stepsSlider, {
		start: [1000000, 60000000],
		step: 500000,
		connect: true,
		format: {
			to: function(value) {
				return value.toLocaleString();

			},
			from: function(minValue) {
				return minValue.toLocaleString();
			}
		},
		range: {
			'min': [1000000],
			'max': [60000000]
		}
	});

	stepsSlider.noUiSlider.on('update', function(values, handle) {

		inputs[handle].value = values[handle];
	});
</script>
<script defer>
	document.addEventListener("DOMContentLoaded", function() {
		let fillters = '';
		let orderQuery = `orderby: {
                  field: DATE, order: DESC
                },`;
		getAndRender(12, null, fillters, 0, 0, <?php echo get_queried_object()->term_id; ?>, orderQuery);
	});

	/**Render lần đầu tiên */
</script>
<?php get_footer(); ?>