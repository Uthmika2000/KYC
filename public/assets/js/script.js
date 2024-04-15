// window.onload = function(){
//     const sidebar = document.querySelector(".sidebar");
//     const closeBtn = document.querySelector("#btn");
//     const searchBtn = document.querySelector(".bx-search")

//     closeBtn.addEventListener("click",function(){
//         sidebar.classList.toggle("open")
//         menuBtnChange()
//     })

//     searchBtn.addEventListener("click",function(){
//         sidebar.classList.toggle("open")
//         menuBtnChange()
//     })

//     function menuBtnChange(){
//         if(sidebar.classList.contains("open")){
//             closeBtn.classList.replace("bx-menu","bx-menu-alt-right")
//         }else{
//             closeBtn.classList.replace("bx-menu-alt-right","bx-menu")
//         }
//     }
// }
document.getElementById('btn').addEventListener('click', () => {
    document.querySelector('.sidebar').classList.toggle('active');
    document.querySelector('.home_content').classList.toggle('active');
  });
  