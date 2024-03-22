const getAndRender=(pageSize,afterCursor,fillters,minPrice,maxPrice,categoryIdIn,orderQuery)=>{addLoading();getProductsFromGraphQL(pageSize,afterCursor,fillters,minPrice,maxPrice,categoryIdIn,orderQuery).then((result)=>{let products=result.nodes;let pageInfo=result.pageInfo;removeLoading();renderProducts(products);const pagination=document.getElementById("pagination");const endCursor=pageInfo.endCursor;if(pageInfo.hasNextPage){let button=document.createElement("button");button.innerText="Xem thêm";button.setAttribute("id","load_more");button.addEventListener("click",function(){const loadMoreButton=document.getElementById("load_more");if(loadMoreButton){loadMoreButton.remove()}
getAndRender(pageSize,endCursor,fillters,minPrice,maxPrice,categoryIdIn,orderQuery)});pagination.appendChild(button)}})};async function getProductsFromGraphQL(pageSize,afterCursor,fillters,minPrice,maxPrice,categoryIdIn,orderQuery){const query=`{
            products(
              where: { 
                ${orderQuery}
                minPrice: ${minPrice},
                maxPrice: ${maxPrice},
                categoryIdIn: ${categoryIdIn},
                ${fillters}
              }
              first: ${pageSize}
              after: "${afterCursor}"
            ) {
              pageInfo {
                hasNextPage
                endCursor
                hasPreviousPage
                startCursor
              }
              nodes {
                ... on SimpleProduct {
                  name
                  price(format: RAW)
                  link
                  image {
                    altText
                    sourceUrl(size: MEDIUM_LARGE)
                  }
                  metaData(keysIn: ["number-heart", "product-sold"]) {
                    key
                    value
                  }
                  productId
                  allPaNuoc {
                    nodes {
                      name
                    }
                  }
                  allPaDoTinhKhiet {
                    nodes {
                      name
                    }
                  }
                  allPaGiatCat {
                    nodes {
                      name
                    }
                  }
                }
              }
            }
          }
      `;let url=window.location.origin==="http://kld.local"?"http://kld.local/graphql":"https://kimlongdiep.com/graphql";try{const response=await fetch(url,{method:"POST",headers:{"Content-Type":"application/json",},body:JSON.stringify({query}),});if(response.ok){const result=await response.json();let data_result=result.data.products;return data_result}else{console.log("Đã xảy ra lỗi khi lấy dữ liệu")}}catch(error){console.log("Đã xảy ra lỗi:",error)}}
const renderProducts=(products)=>{const dataListProduct=document.getElementById("data-list-product");if(products.length==[]){let message=document.createElement("div");message.classList.add("message");message.innerHTML="Không tìm thấy sản phẩm nào";dataListProduct.appendChild(message)}else{products.forEach((product)=>{const{name,image,price,link,metaData,productId,allPaNuoc,allPaDoTinhKhiet,allPaGiatCat,}=product;let productContainer=document.createElement("a");productContainer.href=link;productContainer.classList.add("item_product_category");let productFeatureImage=document.createElement("div");productFeatureImage.classList.add("product_image");let productInfo=document.createElement("div");productInfo.classList.add("product_info");const allItems=[...allPaNuoc.nodes,...allPaDoTinhKhiet.nodes,...allPaGiatCat.nodes,];const listAttributes=document.createElement("ul");if(allItems.length>0){listAttributes.className="list-attributes-product";allItems.forEach((item)=>{const liElement=document.createElement("li");liElement.textContent=item?.name;listAttributes.appendChild(liElement)})}
let productImage=document.createElement("img");if(image!=null){productImage.src=image.sourceUrl;productImage.alt=name}
productFeatureImage.appendChild(productImage);productContainer.appendChild(productFeatureImage);let productName=document.createElement("div");productName.innerText=name;productName.classList.add("product_title");productInfo.appendChild(productName);productInfo.appendChild(listAttributes);let productPrice=document.createElement("div");let randomNumber_heart=((productId+123)%11)+5;let randomNumber_producut_sold=((productId+789)%11)+15;if(price){productPrice.innerHTML=`
                <div class="product_price"> ${Number(
                  price
                ).toLocaleString()} đ</div>
                <div class="fav__sold">
                  <div class="number-heart">
                    ${randomNumber_heart}
                    <i style="color: #ffa61a;margin-right: 5px;" class="fa-solid fa-heart"></i>
                  </div>
                  <div class="product-sold"> 
                      ${randomNumber_producut_sold}+ <span style="color: white; font-weight:400 ;">đã bán</span>
                  </div>
                </div>
            `}
productInfo.appendChild(productPrice);productContainer.appendChild(productInfo);dataListProduct.appendChild(productContainer)})}};const addLoading=()=>{if(document.getElementById("load_more")){document.getElementById("load_more").remove()}
let loading=document.createElement("div");loading.innerText="Đang tải dữ liệu...";loading.classList.add("loading");document.getElementById("data-list-product").appendChild(loading)};const removeLoading=()=>{document.querySelector(".loading").remove()};const getAllValueOnSideBar=()=>{const checkedCategories=[];checkedCategories.length=0;document.querySelectorAll('input[name="category_name"]').forEach((checkbox)=>{if(checkbox.checked){checkedCategories.push(checkbox.value)}});minPrice=Number(document.getElementById("input-with-keypress-0").value.replace(/,/g,""));maxPrice=Number(document.getElementById("input-with-keypress-1").value.replace(/,/g,""));let selectedAttributes=[];document.querySelectorAll(".attibutes_select").forEach((checkbox)=>{if(checkbox.checked){let[paKey,valueAttribute]=checkbox.value.split("--");let tempObjects=`{taxonomy: ${paKey}, terms: "${valueAttribute}"}`;selectedAttributes.push(tempObjects)}});let categories="["+checkedCategories+"]";let fillters=`taxonomyFilter: {
        filters: [${selectedAttributes}], 
        relation: OR
      }`;let orderQuery=`orderby: {
        field: DATE, order: DESC
      },`;return[8,null,fillters,minPrice,maxPrice,categories,orderQuery]};document.querySelector(".button_submit_fillter").addEventListener("click",()=>{let[pageSize,afterCursor,fillters,minPrice,maxPrice,categories,orderQuery,]=getAllValueOnSideBar();document.getElementById("data-list-product").innerHTML="";getAndRender(pageSize,afterCursor,fillters,minPrice,maxPrice,categories,orderQuery)});document.querySelector(".filter_moinhat").addEventListener("click",function(e){document.getElementById("filter_gia").value=0;document.getElementById("data-list-product").innerHTML="";e.target.classList.add("button_active");document.querySelector(".filter_banchay").classList.remove("button_active");let[pageSize,afterCursor,fillters,minPrice,maxPrice,categories,orderQuery,]=getAllValueOnSideBar();orderQuery=`orderby: {
                field: DATE, order: DESC
              },`;getAndRender(pageSize,afterCursor,fillters,minPrice,maxPrice,categories,orderQuery)});document.querySelector(".filter_banchay").addEventListener("click",function(e){document.getElementById("filter_gia").value=0;document.getElementById("data-list-product").innerHTML="";e.target.classList.add("button_active");document.querySelector(".filter_moinhat").classList.remove("button_active");let[pageSize,afterCursor,fillters,minPrice,maxPrice,categories,orderQuery,]=getAllValueOnSideBar();orderQuery=`orderby: {field: TOTAL_SALES, order: DESC},`;getAndRender(pageSize,afterCursor,fillters,minPrice,maxPrice,categories,orderQuery)});document.querySelector("#filter_gia").addEventListener("change",function(element){document.getElementById("data-list-product").innerHTML="";let number=element.target.value;let[pageSize,afterCursor,fillters,minPrice,maxPrice,categories,orderQuery,]=getAllValueOnSideBar();orderQuery=`orderby: {
                field: DATE, order: DESC
              },`;if(number==="0"){minPrice=0;maxPrice=0}else{[minPrice,maxPrice]=number.split("--").map(Number)}
getAndRender(pageSize,afterCursor,fillters,minPrice,maxPrice,categories,orderQuery)})
;