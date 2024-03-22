<?php
/*
Template Name: Livestream Archive
*/

?>

<?php
get_header();
?>
  <style>
    /* input[type="time"]::-webkit-calendar-picker-indicator {
        filter: red;
      } */
    .feature_image{
      display: flex;
      justify-content: center;
      width: 90%;
      margin: auto;
    }
    .arrow-container {
    display: flex;
    justify-content: space-around;
    margin-bottom: 10px;
    }
    .arrow-container i {
      font-size:30px;
    
    }
    input[type="time"]::-webkit-calendar-picker-indicator{
      filter: brightness(0) invert(1);
    }
    input[type="date"]::-webkit-calendar-picker-indicator {
      filter: brightness(0) invert(1);
    }
    .pick_date_livestream input,.pick_hours_livestream input{
      background: transparent;
      border: 1px solid white;
      color: white;
      border-radius: 10px;
      padding: 0.5rem 1rem;
    }
    .sidebar label, .sidebar input {
        margin-bottom: 15px;
    }
    .sidebar label{
      font-weight:600;
        font-size:16px;
        line-height:19.5px
    }
    .sidebar button{
      border-radius: 20px;
      background: var(--black, #111);
      border: 1px solid white;
      color:white;
      width:100%
    }
    .livestream_content{
      padding:10px;
    }
    .long-text {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
    .container {
      max-width: 1140px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      
    }

    .sidebar {
      flex-basis: 15%;
      margin-top: 70px;
    }
    .main-content {
      flex-basis: 84%;
    }
    #livestream-archive{
      border-radius:15px;
      display: flex;
      justify-content: space-evenly;
      flex-wrap: wrap;
      gap: 10px;
      /* background-color:#111111; */
      padding:10px;
      min-height:300px;
    }
    .livestream_item{
      flex-basis: 30%;
      box-sizing: border-box;
      background-color:black;
      border-radius: 10px;
      padding:5px;
    }
    .container {
      display: flex;
     justify-content:center;
    }
    @media (max-width: 768px) {
      .livestream_item {
        flex-basis: 50%;
      }
      .sidebar {
        display:none;
      }
      .main-content {
        flex-basis: 100%;
      }
    }

    @media (max-width: 480px) {
      .livestream_item {
        flex-basis: 100%;
      }
      .sidebar {
      /* flex-basis: 100%; */
      display:none;
      }
      .main-content {
        flex-basis: 100%;
      }
    }
  </style>
</head>
<body>
  
  
  <div class="container">
    <!-- <div class="sidebar">
      <h2 style="font-size:20px">Bộ lọc tìm kiếm</h2>
      <div class="pick_date_livestream">
        <label style="color: var(--vng-logo, #FDCD81);">
          Lọc theo ngày:
        </label>
        <input type="date" name="" id="">
      </div>
    </div> -->
    <div class="main-content">
      <!-- Thêm nội dung cho phần nội dung chính ở đây -->
      <h1 style="color:#FDCD81"><?php the_title(); ?></h1>
      <div id="livestream-archive">
          
          
      </div>
      <div class="arrow-container">
          <a id="button_arrow_left" href="#">
            <i class="fa-solid fa-circle-arrow-left"></i>
          </a>
            <div class=""></div>
            <a id="button_arrow_right" href="#">
              <i class="fa-solid fa-circle-arrow-right"></i>
            </a>
          </div>
    </div>
  </div>
<script>
  const button_arrow_left = document.querySelector("#button_arrow_left");
  const button_arrow_right = document.querySelector("#button_arrow_right");

  function cut_longer_string(text,limitNumberOfText){
            
    const maxLength = limitNumberOfText; 

    if (text.length > maxLength) {
      const truncatedText = text.substring(0, maxLength) + "..."; 
      text = truncatedText; 
    }
    return text;
  }
  function compare2Date(date1_input,date2_input){
    const date1 = new Date(date1_input);
    const date2 = new Date(date2_input);
    // So sánh theo ngày tháng năm (không tính giờ, phút, giây)
    const year1 = date1.getFullYear();
    const month1 = date1.getMonth();
    const day1 = date1.getDate();

    const year2 = date2.getFullYear();
    const month2 = date2.getMonth();
    const day2 = date2.getDate();

    if (year1 === year2 && month1 === month2 && day1 === day2) {
      return true;
    } else {
      return false;
    }

  }
  // Hiển thị nút loading
  const addLoading = ()=>{
        let loading = document.createElement("span");
        loading.innerText = "Đang tải dữ liệu Livestream...";
        loading.classList.add("loading");
        document.querySelector("#livestream-archive").appendChild(loading);
    };
  const removeLoading = ()=>{
    document.querySelector('.loading').remove();
  }
  // lấy livestream từ api
  async function getLivestreamFromFacebook(){
    try {
      let url='';
      if(window.location.origin === 'http://kld.local'){
        url = 'http://kld.local/';
      }else{
        url = 'https://kimlongdiep.com/';
      }
      let reponse = await fetch(url+"wp-json/livestream/v1/getlivestream");
      dataReponsive = await reponse.json();
      
      return dataReponsive;
      
    } catch (error) {
      console.log(error);
      document.querySelector("#livestream-archive").innerHTML = "<h4>Không thể lấy dữ liệu livestream từ facebook</h4>";
    }
  }
  async function getLivestreamWithLink(before_after,value){
    try {
      let url='';
      if(window.location.origin === 'http://kld.local'){
        url = 'http://kld.local/';
      }else{
        url = 'https://kimlongdiep.com/';
      }
      addLoading();
      let reponse = await fetch(url+"wp-json/livestream/v1/paggingLivestream/"+before_after+"/"+value);
      
      dataReponsive = await reponse.json();
      console.log(dataReponsive);
      return dataReponsive;
    } catch (error) {
      console.log(error);
      document.querySelector("#livestream-archive").innerHTML = "<h4>Không thể lấy dữ liệu livestream từ facebook</h4>";
    }
  }
  const renderLivestreamFacebook = (data_livestream) =>{
    // Render livestream
    let livestreamArchive = document.querySelector("#livestream-archive");
    let livestreamsHtml = '';
   
    data_livestream.forEach(element => {
      let limitNumberOfText = 60;
      let description = cut_longer_string(element.description,limitNumberOfText);
      let dateCreate = new Date(element.creation_time);
      // format datecreate to dd/mm/yyyy

      const formattedDate = dateCreate.getDate() + "/" + (dateCreate.getMonth() + 1) + "/" + dateCreate.getFullYear();
      let livestreamItem = document.createElement("div");
      livestreamItem.classList.add("livestream_item");
      let link_thumb = element.video.thumbnail
      livestreamItem.innerHTML = `
        <a target="__blank" href="https://www.facebook.com/${element.permalink_url}">
              <div class="feature_image">
                <img src="${link_thumb}" alt="Livestream của Kim Long Diệp ngày ${element.creation_time}">
              </div>
              <div class="livestream_content">
                <p>${description}</p>
                <span style="font-weight: 400;color: var(--d-9-d-9-d-9, #6B6B6B);">Livestream ngày: ${formattedDate}</span>
              </div>
        </a>
      `
      livestreamArchive.appendChild(livestreamItem);
    });
  }
  /**
   * Render livestream archive
   */
  addLoading();
  getLivestreamFromFacebook().then((livestreams)=>{
    removeLoading();
    //render ban đầu khi sản phẩm được load
    renderLivestreamFacebook(livestreams.data);
    //
    /**
     * Xử lý sự kiện nút chọn ngày livestream
     */
    // const pick_date_livestream = document.querySelector(".pick_date_livestream input");
    // // const pick_hours_livestream = document.querySelector(".pick_hours_livestream input");
    const livestream_archive = document.querySelector("#livestream-archive");
    // // Sự kiện nút thay đổi ngày
    // pick_date_livestream.addEventListener("change",()=>{
    //   const date_pick = pick_date_livestream.value;
    //   livestream_archive.innerHTML = '';
    //   let livestreamWithDate = livestreams.data.filter((livestream)=>{
    //     return compare2Date(date_pick,livestream.creation_time);// so sánh ngày livestream với ngày được chọn
    //   })
    //   if(livestreamWithDate.length === 0){
    //     livestream_archive.innerHTML = '<h4 style="color:#FDCD81">Không có livestream nào trong ngày này</h4>';
    //   }else{
    //     renderLivestreamFacebook(livestreamWithDate);
    //   }
    // })
    // Sự kiện nút mũi tên trái, phải
    if (livestreams.paging.previous==null){
      button_arrow_left.style.display = "none"
    }
    if(livestreams.paging.next==null){
      button_arrow_right.style.display = "none"
    }

    button_arrow_left.addEventListener("click",()=>{
      livestream_archive.innerHTML = '';
     
      if (livestreams.paging.previous==null) {
        document.querySelector("#livestream-archive").innerHTML = "<h4>Không thể lấy dữ liệu livestream từ facebook</h4>";
      }else{
        getLivestreamWithLink('before',livestreams.paging.cursors.before).then((livestreams)=>{
          removeLoading();
          
          renderLivestreamFacebook(livestreams.data);
        })
      }
      

    })
    button_arrow_right.addEventListener("click",()=>{
      livestream_archive.innerHTML = '';
     
      if (livestreams.paging.next==null) {
        document.querySelector("#livestream-archive").innerHTML = "<h4>Không thể lấy dữ liệu livestream từ facebook</h4>";
      }else{
        getLivestreamWithLink('after',livestreams.paging.cursors.after).then((livestreams)=>{
          removeLoading();
          renderLivestreamFacebook(livestreams.data);
        })
      }
      
    })
    
  });
</script>

<?php
get_footer();
?>
