document.addEventListener("DOMContentLoaded",function(){var tabLinks=document.querySelectorAll(".tab-link");for(var i=0;i<tabLinks.length;i++){tabLinks[i].addEventListener("click",function(){for(var j=0;j<tabLinks.length;j++){tabLinks[j].classList.remove("active")}
var tabContents=document.querySelectorAll(".tab");for(var k=0;k<tabContents.length;k++){tabContents[k].classList.remove("active")}
var tabId=this.getAttribute("data-tab");this.classList.add("active");document.getElementById(tabId).classList.add("active")})}})
;