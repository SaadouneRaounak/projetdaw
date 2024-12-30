let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");
let navList = document.querySelector(".nav-list");

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  navList.classList.toggle("scroll");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search icon
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
 if(sidebar.classList.contains("open")){
   closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the icons class
 }else {
   closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the icons class
 }
}
function RefreshChat() {
  setInterval(function () {
      let xhr = new XMLHttpRequest();
      xhr.open("GET", "ReloadChat.php", true);
      xhr.onload = function () {
          if (this.status == 200) {
              document.getElementById("result").innerHTML = this.responseText;
          }
      };
      xhr.send();
  }, 2000);
}

function fetchNotifications() {

  fetch(`FetchNotifications.php?user_id=${userId}`)
      .then(response => response.json())
      .then(data => {
          const container = document.getElementById('notifications-container');
          container.innerHTML = ''; // تنظيف الإشعارات السابقة
          data.forEach(notification => {
              const div = document.createElement('div');
              div.classList.add('notification');
              div.innerHTML = `
                  <p>${notification.message}</p>
                  <small>${new Date(notification.created_at).toLocaleString()}</small>
              `;
              container.appendChild(div);
          });
      })
      .catch(err => console.error('Error fetching notifications:', err));
}

// تحديث الإشعارات كل 5 ثوانٍ
setInterval(fetchNotifications, 5000);
fetchNotifications(); // استدعاء أولي عند تحميل الصفحة