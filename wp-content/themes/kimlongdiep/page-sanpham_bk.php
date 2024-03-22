<?php

/*
Template Name: Trang sản phẩm
*/
get_header();
?>
<style>
  .product_attribute_option label {
    cursor: pointer;
    text-transform: capitalize;
    line-height: 1rem;
  }

  hr {
    color: #B5B5B5;
    margin: 15px 0px;
  }

  .main-content {
    margin: 20px;
  }

  body {
    font-family: Montserrat;
  }

  button {
    border-radius: 20px;
    border: 1px solid var(--d-9-d-9-d-9, #B5B5B5);
    color: var(--d-9-d-9-d-9, #B5B5B5);
  }

  button:hover,
  button:focus,
  .button_active {
    color: var(--d-9-d-9-d-9, #FFA61A);
    border: 1px solid var(--d-9-d-9-d-9, #FFA61A) !important;
    background-color: transparent;
  }

  #button_filter {
    border-radius: 20px;
    background: var(--black, #111);
    color: white;
    border: none;
    width: 100%;
  }

  .top_filter {
    width: 100%;
    display: flex;
    justify-content: start;
    gap: 15px;
    margin-bottom: 10px;
  }

  .filter_phobien,
  .filter_moinhat,
  .filter_banchay {
    border-radius: 20px;
    padding: 8px 20px;

  }

  #filter_gia {

    width: 230px;
    gap: 110px;
    border-radius: 20px;
    border: 1px solid var(--d-9-d-9-d-9, #B5B5B5);
    background-color: transparent;
    color: #B5B5B5;
  }

  .product_attribute_option {
    color: var(--trng, #FFF);
    font-size: 14px;
    margin: 5px;
  }

  .product_attribute_title {
    color: #FDCD81;
    font-size: 16px;
    font-weight: 600;
  }

  .main-content {
    display: flex;
    justify-content: center;
    width: 100%;
  }

  .category_page {
    width: 1140px;
  }

  .content-area {
    display: flex;
    gap: 10px;
    margin: 25px 0px;
    min-height: 200px;
  }

  .sidebar_filter_product {
    width: calc(20% - 5px);
  }

  .list_product_content {
    width: calc(80% - 5px);
  }

  /* reponsive cho list sản phẩm */
  #data-list-product {
    display: flex;
    flex-wrap: wrap;
    /* justify-content: space-between; */
    gap: 5px;
    padding: 10px;
  }

  .item_product_category {
    width: calc(25% - 5px);
    margin-bottom: 20px;
    padding: 20px;
    background-color: #000000;
    box-sizing: border-box;
    border-radius: 15px;
  }

  .product_image {
    text-align: center;
    height: 180px;
    overflow: hidden;
    border-radius: 5px;
  }

  .product_image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    scale: 1.2;
  }

  .product_title {
    margin-top: 10px;
    color: #FFF;
    font-size: 14px;
    font-weight: 500;
    line-height: 21px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
  }

  .product_price {
    margin-top: 5px;
    color: var(--gi, #FFBF41);
    font-size: 14px;
    font-weight: 600;
    line-height: 21px;
  }

  /* Responsive styles for tablet */
  @media (max-width: 864px) {
    .sidebar_filter_product {
      display: none;
    }


    #data-list-product {
      padding: 5px;
    }

    .item_product_category {
      width: calc(33.33% - 5px);
    }

    .list_product_content {
      width: 100%;
    }
  }

  /* Responsive styles for mobile */
  @media (max-width: 480px) {
    .top_filter span {
      display: block;
      margin: 10px 0px;
    }

    .filter_moinhat {
      width: 50%;
    }

    .filter_banchay {
      width: calc(50% - 5px);
    }

    #filter_gia {
      width: 100%;
      margin-top: 7px;
    }

    .category_page {
      width: 100%;
    }

    .sidebar_filter_product {
      display: none;
    }

    .list_product_content {
      width: 100%;
    }

    .item_product_category {
      width: calc(50% - 5px);
      padding: 10px;
      margin-bottom: 6px;
    }

    .top_filter {
      display: block;
    }

    .main-content {
      margin-top: 25px;
    }
  }
</style>
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
      </main>
    </div>
  </div>
</div>
<script defer>
  // Thực hiện yêu cầu truy vấn GraphQL để lấy thông tin sản phẩm từ danh mục
  const dataListProduct = document.getElementById("data-list-product");

  // Xử lý sự kiện các nút filter

  const queryProductsCategory = `{
      products(where: {orderby: {field: DATE, order: DESC}}, first: 20) {
        edges {
          node {
            id
            name
            image {
              sourceUrl
            }
            sku
            attributes {
              nodes {
                name
                options
              }
            }
            slug
            ... on SimpleProduct {
              id
              name
              price(format: RAW)
            }
          }
        }
      }
    }`;
  // Lấy sản phẩm từ GraphQL
  async function getProductsFromGraphQL(query) {

    try {
      let url = '';
      if (window.location.origin === 'http://localhost') {
        url = 'http://localhost/KLD/graphql';
      } else {
        url = 'https://kimlongdiep.com/graphql';
      }
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          query
        }),
      });

      if (response.ok) {
        const result = await response.json();

        let products = result.data.products.edges;
        // Xóa nút loading
        return products;
      } else {
        console.log('Đã xảy ra lỗi khi lấy dữ liệu');
      }

    } catch (error) {
      console.log('Đã xảy ra lỗi:', error);


    }
  }
  // Load sản phẩm lên trang
  const renderProducts = (products) => {
    // console.log(products.length==[]); 
    if (products.length == []) {
      // add element message "no product found"
      let message = document.createElement("div");
      message.classList.add("message");
      message.innerHTML = "Không tìm thấy sản phẩm nào";
      dataListProduct.appendChild(message);
    } else {
      products.forEach((product) => {
        const {
          id,
          name,
          image,
          sku,
          attributes,
          price,
          slug
        } = product.node;
        // Tạo phần tử container cho sản phẩm
        let productContainer = document.createElement("a");
        productContainer.href = '/san-pham/' + slug;
        productContainer.classList.add("item_product_category");

        let productFeatureImage = document.createElement("div");
        productFeatureImage.classList.add("product_image");
        let productInfo = document.createElement("div");
        productInfo.classList.add("product_info");
        // Tạo phần tử hình ảnh
        let productImage = document.createElement("img");
        productImage.src = image.sourceUrl;
        productImage.alt = name;

        productFeatureImage.appendChild(productImage);
        productContainer.appendChild(productFeatureImage);

        // Tạo phần tử tên sản phẩm
        let productName = document.createElement("div");
        productName.innerText = name;
        productName.classList.add("product_title");
        productInfo.appendChild(productName);

        // Tạo phần tử giá sản phẩm
        let productPrice = document.createElement("div");
        productPrice.innerText = Number(price).toLocaleString() + " đ";
        productPrice.classList.add("product_price");
        productInfo.appendChild(productPrice);
        productContainer.appendChild(productInfo);

        // Thêm sản phẩm vào danh sách
        dataListProduct.appendChild(productContainer);
      });
    }


  }
  // Lấy thuộc tính của sản phẩm đang hiện trên trang và render nó ra sidebar
  const getProductAttributesAndRenderToSidebar = (products) => {
    // Gộp các mảng "attributes" và loại bỏ các phần tử trùng nhau
    const mergedAttributes = products.reduce((result, edge) => {
      const attributes = edge.node.attributes.nodes;
      attributes.forEach(attribute => {
        if (attribute.name !== "Mặt" && attribute.name !== "Giới tính" && attribute.name !== "Chất liệu" && attribute.name !== "Đơn Vị Tính") {
          const existingAttribute = result.find(item => item.name === attribute.name);
          if (existingAttribute) {
            existingAttribute.options = [...new Set([...existingAttribute.options, ...attribute.options])];
          } else {
            result.push(attribute);
          }
        }
      });
      return result;
    }, []);
    //Render các thuộc tính ra sidebar
    const sidebarAttributes = document.querySelector(".sidebar_filter_product");
    //apenchild element to sidebarAttributes
    mergedAttributes.forEach((attribute) => {
      let attributeContainer = document.createElement("div");
      attributeContainer.classList.add("filter_product");
      let attributeTitle = document.createElement("div");
      attributeTitle.classList.add("product_attribute_title");
      attributeTitle.innerText = attribute.name;
      attributeContainer.appendChild(attributeTitle);
      let attributeOptions = document.createElement("div");
      attributeOptions.classList.add("filter_group_product_options");
      attribute.options.forEach((option) => {
        let optionContainer = document.createElement("div");
        optionContainer.classList.add("filter_product_option");

        let optionLabel = document.createElement("label");
        optionLabel.innerHTML = `<label><input class="filter_product_option_input" type="checkbox" value="${attribute.name}--${option}"> ${option}</label>`;
        optionLabel.classList.add("product_attribute_option");

        optionContainer.appendChild(optionLabel);
        attributeOptions.appendChild(optionContainer);
      });
      //add hr tag to attributeOptions
      let hr = document.createElement("hr");
      hr.classList.add("hr_filter_product");
      attributeOptions.appendChild(hr);

      attributeContainer.appendChild(attributeOptions);
      sidebarAttributes.appendChild(attributeContainer);
    });

  }
  // Hiển thị nút loading
  const addLoading = () => {
    let loading = document.createElement("span");
    loading.innerText = "Loading...";
    loading.classList.add("loading");
    document.getElementById("data-list-product").appendChild(loading);
  }
  const removeLoading = () => {
    document.querySelector('.loading').remove();
  }
  addLoading();

  getProductsFromGraphQL(queryProductsCategory).then((products) => {
    /**
     * Render khi lần đầu load trang
     */
    //Xóa nút Loading khi đã lấy được sản phẩm
    removeLoading();
    //lấy thuộc tính của sản phẩm
    getProductAttributesAndRenderToSidebar(products);
    /**
     * Xử lý sự kiện nút filter phía bên trái
     *
     **/
    // Lặp qua danh sách các checkbox và thêm sự kiện click
    document.querySelectorAll('.filter_product_option_input').forEach(checkbox => {
      checkbox.addEventListener('change', () => {
        const selectedValues = Array.from(document.querySelectorAll('.filter_product_option_input:checked')).map(checkbox => checkbox.value);

        const objectsDieuKien = selectedValues.map(value => {
          const [key, val] = value.split('--');
          return {
            [key.trim()]: val.trim()
          };
        });
        //loop products array and filter product with objectsDieuKien
        let productsFilter = products.filter((product) => {
          let check = true;
          objectsDieuKien.forEach((object) => {
            let key = Object.keys(object)[0];
            let value = Object.values(object)[0];
            let attributes = product.node.attributes.nodes;
            let checkAttribute = false;
            attributes.forEach((attribute) => {
              if (attribute.name == key) {
                attribute.options.forEach((option) => {
                  if (option == value) {
                    checkAttribute = true;
                  }
                })
              }
            })
            if (checkAttribute == false) {
              check = false;
            }
          })
          return check;
        });
        //render productsFilter to page
        document.getElementById("data-list-product").innerHTML = '';
        renderProducts(productsFilter);

      });

    });
    //render sản phẩm
    renderProducts(products);

    /**
     * Xử lý sự kiện các nút filter phía trên
     */

    document.querySelector(".filter_moinhat").addEventListener("click", function(e) {
      document.getElementById('filter_gia').value = 0;
      document.getElementById("data-list-product").innerHTML = '';
      e.target.classList.add("button_active");
      //remove class "button_active" in filter_banchay
      document.querySelector(".filter_banchay").classList.remove("button_active");

      renderProducts(products);
    });
    document.querySelector(".filter_banchay").addEventListener("click", function(e) {
      document.getElementById('filter_gia').value = 0
      document.getElementById("data-list-product").innerHTML = '';
      e.target.classList.add("button_active");
      //remove class "button_active" in filter_banchay
      document.querySelector(".filter_moinhat").classList.remove("button_active");
      const sortedEdges = products.sort((a, b) => {
        if (a.node.totalSales && b.node.totalSales) {
          return b.node.totalSales - a.node.totalSales; // Sắp xếp theo totalSales giảm dần nếu có trường totalSales
        } else {
          return -1; // Đẩy các phần tử có totalSales lên trước
        }
      });
      renderProducts(sortedEdges);
    });
    document.querySelector("#filter_gia").addEventListener("change", function(element) {
      document.getElementById("data-list-product").innerHTML = '';

      let number = element.target.value;
      if (number === '0') {
        renderProducts(products);
        return;
      }
      const [start_price, end_price] = number.split('--').map(Number);

      const filteredEdges = products.filter((edge) => {
        const price = Number(edge.node.price);
        return price >= start_price && price <= end_price;
      });

      //check if filteredEdges is empty show message 'Không có sản phẩm nào'
      if (filteredEdges.length == 0) {
        let message = document.createElement("div");
        message.innerText = "Không có sản phẩm nào";
        message.classList.add("message");
        document.getElementById("data-list-product").appendChild(message);
      } else {
        renderProducts(filteredEdges);
      }
    });
  });
</script>
<?php
get_footer();
?>