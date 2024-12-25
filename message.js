let messages = [
    { id: 1, subject: "Welcome", preview: "Thank you for joining our platform.", type: "inbox", timestamp: "2024-12-01 10:30" },
    { id: 2, subject: "Confirmation of sending", preview: "your message has been sent successfully.", type: "sent", timestamp: "2024-12-03 09:45" },
];
// Display Messages
function displayMessages(filter = "inbox") {
    const messageList = document.getElementById("messageList");
    messageList.innerHTML = ""; // Clear previous messages

    const filteredMessages = messages.filter(msg => msg.type === filter);

    if (filteredMessages.length === 0) {
        messageList.innerHTML = "<p><h1> No messages found.<h1></p>";
        return;
    }

    
      filteredMessages.forEach(msg => {
        const messageItem = document.createElement("div");
        messageItem.classList.add("message-item");
        messageItem.innerHTML = `
            <div class="info">
                <div class="subject">${msg.subject}</div>
                <div class="preview">${msg.preview}</div>
                <div class="timestamp">${msg.timestamp}</div>
            </div>
            <button class="delete-btn" onclick="deleteMessage(${msg.id})"><i class="fas fa-trash"></i>Delete</button>
            <button class="archive-btn" onclick="archiveMessage(${msg.id})"><i class="fas fa-archive"></i>Archive</button>
      `;
        messageList.appendChild(messageItem);
    });
      }


// Debounced Search
let debounceTimeout;
function debounceSearch() {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        const query = document.getElementById("searchInput").value;
        searchMessages(query);
    }, 300); // Delay of 300ms
}

function searchMessages(query) {
    const messageList = document.getElementById("messageList");
    const allMessages = document.querySelectorAll(".message-item");

    allMessages.forEach(msg => {
        if (msg.textContent.toLowerCase().includes(query.toLowerCase())) {
            msg.style.display = "block";
        } else {
            msg.style.display = "none";
        }
    });
}

// Modal Functions
function openComposeModal() {
    document.getElementById("composeModal").style.display = "flex";
}

function closeComposeModal() {
    document.getElementById("composeModal").style.display = "none";
}

// Send Message
function sendMessage() {
    const recipient = document.getElementById("recipient").value;
    const subject = document.getElementById("subject").value;
    const body = document.getElementById("messageBody").value;


    /*
    if (!recipient || !subject || !body) {
        alert("Please fill in all fields.");
        return;
    }*/

    messages.push({
        id: messages.length + 1,
        subject,
        preview: body.substring(0, 50),
        type: "sent",
        timestamp: new Date().toISOString().slice(0, 16).replace("T", " ")
    });

    alert("Message Envoyé!");
    closeComposeModal();
    displayMessages("sent");
}

// Initialize
window.onload = () => {
    displayMessages();
};
function deleteMessage(messageId) {

    // حذف الرسالة من القائمة
    messages = messages.filter(msg => msg.id !== messageId);

    // تحديث عرض الرسائل
    displayMessages();
}
window.onload = () => {
    displayMessages();
};
function archiveMessage(messageId) {
    // Trouver l'index du message à archiver
    const messageIndex = messages.findIndex(msg => msg.id === messageId);

    if (messageIndex !== -1) {
        // Modifier le type du message pour "archive"
        messages[messageIndex].type = "archive";

        // Afficher un message de confirmation
        alert("Le message a été archivé avec succès!");

        // Actualiser l'affichage de la liste des messages
        displayMessages(currentFilter);
    }/* else {
        alert("Message introuvable.");
    }*/
}

let currentFilter = "inbox"; // Catégorie par défaut

function filterMessages(filter) {
    currentFilter = filter; // Met à jour la catégorie active

    // Mettre en surbrillance la catégorie sélectionnée
    const menuItems = document.querySelectorAll(".menu li a");
    menuItems.forEach(item => {
        if (item.getAttribute("onclick").includes(filter)) {
            item.classList.add("active");
        } else {
            item.classList.remove("active");
        }
    });

    // Appeler la fonction pour afficher les messages de la catégorie
    displayMessages(filter);
}
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
