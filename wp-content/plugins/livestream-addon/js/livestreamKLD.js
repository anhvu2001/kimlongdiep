// Lấy phần tử cần thay đổi vị trí
var livestreamElement = document.getElementById("feature_livestream_homepage");

// Tạo phần tử nút X
var closeButton = document.createElement("button");
closeButton.innerText = "X";
closeButton.style.position = "absolute";
closeButton.style.top = "0";
closeButton.style.right = "0";
closeButton.style.padding = "5px";
// closeButton.style.backgroundColor = "black";
closeButton.style.color = "white";
closeButton.style.border = "white";
closeButton.style.cursor = "pointer";

// Thêm sự kiện click cho nút X để ẩn phần tử cha khi được nhấp
let  closed = false;
closeButton.addEventListener("click", function() {
	active_close();
});
// Bắt sự kiện cuộn trang
// 

  var screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;


if(screenWidth>=992){
   window.addEventListener("scroll", function() {
  // Kiểm tra vị trí của người dùng
  let scrollPosition = window.scrollY || window.pageYOffset;
  
  // Kiểm tra nếu người dùng đã cuộn xuống đủ xa
 
	 if (closed===false && scrollPosition > 100) {
		    // Thay đổi vị trí của phần tử
		    livestreamElement.appendChild(closeButton);
			livestreamElement.style.position = "fixed";
			livestreamElement.style.width = "21.482%";

			livestreamElement.style.right = "10px";
			livestreamElement.style.bottom = "0px";
			livestreamElement.style["z-index"] = "999";

		   } else {
			 // Khôi phục vị trí ban đầu
			livestreamElement.style.position = "static";
			 livestreamElement.style.right = "unset";
			 livestreamElement.style.bottom = "unset";
			livestreamElement.style.width = "36.482%";

		   }
	 } 
  
);
}

function active_close(){
	closed=true;
	livestreamElement.style.position = "static";
	livestreamElement.style.right = "unset";
	livestreamElement.style.bottom = "unset";
	livestreamElement.style.width = "36.482%";
}