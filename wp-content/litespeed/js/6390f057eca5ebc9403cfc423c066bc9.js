const idCategoryPost=document.querySelector(".mix-match-container-category-post")?.getAttribute("data-id");const pagination=document.getElementById("pagination-category-post");const links=pagination.querySelectorAll("a");butPrevBycategory=document.getElementById("btn-pagination-byCategory-prev");butNextBycategory=document.getElementById("btn-pagination-byCategory-next");var afterCursor=null;var startCursor=null;var hasNextPage=!0;var hasPreviousPage=!1;var isLoading=!1;var first=8;var last=null;var currentPage=1;let previousPage=1;var totalPageCount=links.length;var visiblePages=4;let fistLoad=!0;const queryPostByCategory=`
query($categoryId: Int!, $after: String, $before: String, $first: Int, $last: Int) {
  posts(where: { categoryId: $categoryId }, first: $first, last: $last, after: $after, before: $before) {
    edges {
      node {
        title
        link
        date
        featuredImage {
          node {
            sourceUrl
          }
        }
      }
    }
    pageInfo {
      hasNextPage
      hasPreviousPage
      endCursor
      startCursor
    }
  }
}
`;const addLoading=()=>{let loading=document.createElement("div");let overlay=document.createElement("div");overlay.classList.add("overlay");loading.classList.add("loader");const postContainer=document.getElementById(`idCategoryPost${idCategoryPost}`);overlay?.appendChild(loading);postContainer?.appendChild(overlay);if(!fistLoad){overlay.style.backgroundColor="rgba(0, 0, 0, 0.5)"}else overlay.style.backgroundColor="transparent"};const removeLoading=()=>{const loader=document.querySelector(".loader");loader?.remove()};const getMorePosts=async()=>{addLoading();fistLoad=!1;const response=await fetch("https://kimlongdiep.com/graphql",{method:"POST",headers:{"Content-Type":"application/json",},body:JSON.stringify({query:queryPostByCategory,variables:{categoryId:parseInt(idCategoryPost),after:afterCursor,before:null,first:first,last:last,},}),});if(response.ok){const result=await response.json();const{edges,pageInfo}=result.data.posts;hasNextPage=pageInfo.hasNextPage;hasPreviousPage=pageInfo.hasPreviousPage;if(edges.length>0){afterCursor=pageInfo.endCursor;startCursor=pageInfo.startCursor;renderPosts(edges)}}else{console.log("Đã xảy ra lỗi khi lấy dữ liệu")}
removeLoading()};const getPreviousPosts=async()=>{addLoading();fistLoad=!1;const response=await fetch("https://kimlongdiep.com/graphql",{method:"POST",headers:{"Content-Type":"application/json",},body:JSON.stringify({query:queryPostByCategory,variables:{categoryId:parseInt(idCategoryPost),after:null,before:startCursor,first:null,last:8,},}),});if(response.ok){const result=await response.json();const{edges,pageInfo}=result.data.posts;hasNextPage=pageInfo.hasNextPage;hasPreviousPage=pageInfo.hasPreviousPage;if(edges.length>0){startCursor=pageInfo.startCursor;afterCursor=pageInfo.afterCursor;renderPosts(edges)}}else{console.log("Đã xảy ra lỗi khi lấy d liệu")}
removeLoading()};const renderPosts=(posts)=>{const postContainer=document.getElementById(`idCategoryPost${idCategoryPost}`);if(!postContainer)return;postContainer.innerHTML="";posts.forEach((post)=>{const{title,date,featuredImage,link}=post.node;const dateTime=new Date(date);const optionsDate={day:"numeric",month:"long",year:"numeric"};const formattedDate=dateTime.toLocaleDateString("vi-VN",optionsDate);const postElement=document.createElement("div");postElement.classList.add("mix-match-card");const postLink=document.createElement("a");postLink.setAttribute("href",link);const postImage=document.createElement("img");postImage.classList.add("mix-match-post-thumbnail");postImage.setAttribute("src",featuredImage?.node.sourceUrl);postImage.setAttribute("alt",title);const postContent=document.createElement("div");postContent.classList.add("mix-match-post-content");const cardImage=document.createElement("div");cardImage.classList.add("mix-match-card-image");const postTitle=document.createElement("a");postTitle.classList.add("mix-match-post-title");postTitle.textContent=title;postTitle.setAttribute("href",link);const postDate=document.createElement("p");postDate.classList.add("mix-match-post-date");postDate.textContent=formattedDate;postElement.appendChild(postLink);postElement.appendChild(postContent);postLink.appendChild(cardImage);cardImage.appendChild(postImage);postContent.appendChild(postTitle);postContent.appendChild(postDate);postContainer.appendChild(postElement)})};function hideAndShowButton(){butPrevBycategory.style.display=hasPreviousPage||currentPage>1?"flex":"none";butNextBycategory.style.display=currentPage===totalPageCount?"none":"flex";butPrevBycategory.style.display=currentPage===1?"none":"flex"}
getMorePosts();hideAndShowButton();if(links.length<=1){pagination.style.display="none"}
for(var i=visiblePages;i<totalPageCount;i++){links[i].style.display="none"}
function showPageLinks(page){var startIndex=Math.max(page-Math.floor(visiblePages/2),1);for(var i=4;i<totalPageCount;i++){links[i].remove()}
if(totalPageCount<visiblePages){links.forEach((link)=>{link.classList.remove("active")});for(var i=0;i<visiblePages;i++){links[page-1].classList.add("active")}}else{for(var i=0;i<visiblePages;i++){var pageToShow=startIndex+i;links[i].innerText=pageToShow;links[i].style.display="flex"}
links.forEach((link)=>{link.classList.remove("active")});links[page-startIndex].classList.add("active");if(page===totalPageCount){for(var i=0;i<visiblePages;i++){var pageToShow=totalPageCount-visiblePages+i+1;links[i].innerText=pageToShow;links[i].style.display="flex"}
links[visiblePages-1].classList.add("active");links[visiblePages-2].classList.remove("active")}}}
function handleNextClick(){if(currentPage<totalPageCount){currentPage++;hideAndShowButton();showPageLinks(currentPage);if(currentPage===totalPageCount){afterCursor=null;first=null;last=8;getMorePosts()}else{first=8;last=null;getMorePosts()}}}
function handlePrevClick(){if(currentPage>1){currentPage--;hideAndShowButton();showPageLinks(currentPage);getPreviousPosts()}
currentPage===1?(butPrevBycategory.style.display="none"):(butPrevBycategory.style.display="flex")}
butPrevBycategory.addEventListener("click",handlePrevClick);butNextBycategory.addEventListener("click",handleNextClick);showPageLinks(currentPage);if(pagination){pagination.addEventListener("click",(event)=>{if(event.target.tagName==="A"){event.preventDefault();previousPage=currentPage;currentPage=parseInt(event.target.textContent);currentPage=currentPage;hideAndShowButton();showPageLinks(currentPage);if(currentPage===links.length){afterCursor=null;first=null;last=8;getMorePosts()}
if(currentPage===1){afterCursor=null;first=8;last=null;getMorePosts()}
if(previousPage>currentPage&&currentPage!==1){getPreviousPosts()}else if(previousPage<currentPage&&currentPage!==1&&currentPage!==links.length){getMorePosts()}}})}
;