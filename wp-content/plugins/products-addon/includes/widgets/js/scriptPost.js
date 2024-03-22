function getPostMixandMatch() {
  var afterCursor = null;
  var startCursor = null;
  var hasNextPage = true;
  var hasPreviousPage = false;
  var first = 13;
  var last = null;
  const pagination = document.getElementById("pagination");
  const links = pagination.querySelectorAll("a");
  var currentPage = 1;
  let previousPage = 1;
  var totalPageCount = links.length;
  var visiblePages = 4;
  let fistLoad =true;
  butPrev = document.getElementById("btn-pagination-mix-match-prev");
  butNext = document.getElementById("btn-pagination-mix-match-next");
  const queryPostByCategory = `
  query( $after: String, $before: String, $first: Int, $last: Int) {
    posts(where: {orderby: {field: DATE, order: DESC}}, first: $first, last: $last, after: $after, before: $before) {
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
`;

 const addLoading = () => {
    let loading = document.createElement("div");
    let overlay = document.createElement("div");
    overlay.classList.add("overlay");
    loading.classList.add("loader");
    const postContainer = document.getElementById("getallposts");
    overlay?.appendChild(loading);
    postContainer?.appendChild(overlay);
    if (!fistLoad) {
      overlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)";
    } else overlay.style.backgroundColor = "transparent";
  };

  const removeLoading = () => {
    const loader = document.querySelector(".loader");
    loader?.remove();
  };

  const getMorePosts = async () => {
    addLoading();
    fistLoad = false;
    const response = await fetch("https://kimlongdiep.com/graphql", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        query: queryPostByCategory,
        variables: {
          after: afterCursor,
          before: null,
          first: first,
          last: last,
        },
      }),
    });

    if (response.ok) {
      const result = await response.json();
      let { edges, pageInfo } = result.data.posts;
      hasNextPage = pageInfo.hasNextPage;
      hasPreviousPage = pageInfo.hasPreviousPage;
      afterCursor = pageInfo.endCursor;
      startCursor = pageInfo.startCursor;
      if (currentPage === 1) {
        edges = edges.slice(5);
      }
      renderPosts(edges);
    } else {
      console.log("Đã xảy ra lỗi khi lấy d liệu");
    }
    removeLoading();
  };

  const getPreviousPosts = async () => {
    addLoading();
    const response = await fetch("https://kimlongdiep.com/graphql", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        query: queryPostByCategory,
        variables: {
          after: null,
          before: startCursor,
          first: null,
          last: 8,
        },
      }),
    });

    if (response.ok) {
      const result = await response.json();
      const { edges, pageInfo } = result.data.posts;
      hasNextPage = pageInfo.hasNextPage;
      hasPreviousPage = pageInfo.hasPreviousPage;
      startCursor = pageInfo.startCursor;
      afterCursor = pageInfo.afterCursor;
      renderPosts(edges);
    } else {
      console.log("Đã xy ra li khi ly dữ liệu");
    }
    removeLoading();
  };
  function hideAndShowButton() {
    butPrev.style.display =
      hasPreviousPage || currentPage > 1 ? "flex" : "none";
    butNext.style.display = currentPage === totalPageCount ? "none" : "flex";
    butPrev.style.display = currentPage === 1 ? "none" : "flex";
  }

  const renderPosts = (posts) => {
    const postContainer = document.getElementById("getallposts");
    if (!postContainer) return;

    postContainer.innerHTML = "";
    posts.forEach((post) => {
      const { title, date, featuredImage, link } = post.node;
      const dateTime = new Date(date);
      const optionsDate = { day: "numeric", month: "long", year: "numeric" };
      const formattedDate = dateTime.toLocaleDateString("vi-VN", optionsDate);

      const postElement = document.createElement("div");
      postElement.classList.add("mix-match-card");

      const postLink = document.createElement("a");
      postLink.setAttribute("href", link);
      const postImage = document.createElement("img");
      postImage.classList.add("mix-match-post-thumbnail");
      postImage.setAttribute("src", featuredImage?.node.sourceUrl);
      postImage.setAttribute("alt", title);

      const postContent = document.createElement("div");
      postContent.classList.add("mix-match-post-content");
      const cardImage = document.createElement("div");
      cardImage.classList.add("mix-match-card-image");

      const postTitle = document.createElement("a");
      postTitle.classList.add("mix-match-post-title");
      postTitle.textContent = title;
      postTitle.setAttribute("href", link);

      const postDate = document.createElement("p");
      postDate.classList.add("mix-match-post-date");
      postDate.textContent = formattedDate;

      postElement.appendChild(postLink);
      postElement.appendChild(postContent);
      postLink.appendChild(cardImage);
      cardImage.appendChild(postImage);
      postContent.appendChild(postTitle);
      postContent.appendChild(postDate);

      postContainer.appendChild(postElement);
    });
  };
  getMorePosts();
  hideAndShowButton();
  if (totalPageCount <= 1) {
    pagination.style.display = "none";
    butNext.style.display = "none";
    butPrev.style.display = "none";
  }
  for (var i = visiblePages; i < totalPageCount; i++) {
    links[i].style.display = "none";
  }
  function showPageLinks(page) {
    var startIndex = Math.max(page - Math.floor(visiblePages / 2), 1);
    for (var i = 4; i < totalPageCount; i++) {
      links[i].remove();
    }
    if (totalPageCount < visiblePages) {
      links.forEach((link) => {
        link.classList.remove("active");
      });
      for (var i = 0; i < visiblePages; i++) {
        links[page - 1].classList.add("active");
      }
    } else {
      for (var i = 0; i < visiblePages; i++) {
        var pageToShow = startIndex + i;
        links[i].innerText = pageToShow;
        links[i].style.display = "flex";
      }

      links.forEach((link) => {
        link.classList.remove("active");
      });
      links[page - startIndex].classList.add("active");

      if (page === totalPageCount) {
        for (var i = 0; i < visiblePages; i++) {
          var pageToShow = totalPageCount - visiblePages + i + 1;
          links[i].innerText = pageToShow;
          links[i].style.display = "flex";
        }
        links[visiblePages - 1].classList.add("active");
        links[visiblePages - 2].classList.remove("active");
      }
    }
  }
  showPageLinks(currentPage);

  function handleNextClick() {
    if (currentPage < totalPageCount) {
      currentPage++;
      hideAndShowButton();
      showPageLinks(currentPage);
      if (currentPage === totalPageCount) {
        afterCursor = null;
        first = null;
        last = 8;
        getMorePosts();
      } else {
        first = 8;
        last = null;
        getMorePosts();
      }
    }
  }
  function handlePrevClick() {
    if (currentPage > 1) {
      currentPage--;
      hideAndShowButton();
      showPageLinks(currentPage);
      getPreviousPosts();
    }
    currentPage === 1
      ? (butPrev.style.display = "none")
      : (butPrev.style.display = "flex");
  }
  butPrev.addEventListener("click", handlePrevClick);
  butNext.addEventListener("click", handleNextClick);

  if (pagination) {
    pagination.addEventListener("click", (event) => {
      if (event.target.tagName === "A") {
        event.preventDefault();
        previousPage = currentPage;
        currentPage = parseInt(event.target.textContent);
        hideAndShowButton();
        showPageLinks(currentPage);
        if (currentPage === totalPageCount) {
          afterCursor = null;
          first = null;
          last = 8;
          getMorePosts();
        } else if (currentPage === 1) {
          afterCursor = null;
          first = 13;
          last = null;
          getMorePosts();
        } else if (previousPage > currentPage && currentPage !== 1) {
          getPreviousPosts();
        } else if (
          previousPage < currentPage &&
          currentPage !== 1 &&
          currentPage !== totalPageCount
        ) {
          first = 8;
          last = null;
          getMorePosts();
        }
      }
    });
  }
}
getPostMixandMatch();
