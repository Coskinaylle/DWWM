let personnage = null;
  const meta = document.querySelector('meta[name="csrf_token"]');
  const csrfToken = meta ? meta.getAttribute("content") : "";

// ===== MENU BURGER ===== //
function togglemenu() {
  const btnburger = document.getElementById("btnburger");
  const menuburger = document.getElementById("menuburger");

  if (!btnburger || !menuburger) return;

  btnburger.addEventListener("click", function () {
    menuburger.classList.toggle("show");
  });
}

// ===== TITLE DYNAMIQUE ===== //
function title() {
  const titre = document.title;
  const h1 = document.getElementById("titre");
  if (!h1) return;

  const menu = document.querySelectorAll("a");
  if (window.matchMedia("(min-device-width: 801px)").matches) {
    h1.textContent = "";
  } else {
    h1.textContent = titre;
    h1.classList.toggle("menu-link");
    h1.classList.toggle("selected");
    menu.forEach((link) => link.classList.remove("selected"));
  }
}

// ===== MENU LATERAL ===== //
function gameMenu() {
  const toggle = document.getElementById("toggle_button");
  const menu = document.getElementById("menu");
  const gameMenu = document.getElementById("game_menu");

  if (!toggle || !gameMenu || !menu)
    return;
  
  toggle.addEventListener("click", (e) => {
  menu.classList.toggle('open');  
  })
}

// ===== CHAT ====== //
(function () {
  const chatbox = document.getElementById("chatbox");
  const chatmsg = document.getElementById("chatmsg");
  const message = document.getElementById("message");
  if (!chatbox || !chatmsg || !message) return;

  function grabMessages() {
    fetch("../../api/chat.php?action=fetch", { 
      credentials: "same-origin",
    headers: {
      "CSRF-Token": csrfToken 
    }
  })
      .then((rep) => rep.json())
      .then((data) => {
        chatbox.innerHTML = data.messages
          .map(
            (m) =>
              `<div class="msg"><strong>${m.pseudo}: </strong>${m.message}</div>`
          )
          .join("");
        chatbox.scrollTop = chatbox.scrollHeight;
      })
      .catch((err) => console.error("Erreur réception messagerie", err));
  }

  chatmsg.addEventListener("submit", (e) => {
    e.preventDefault();
    const msg = message.value.trim();
    if (!msg) return;

    fetch("../../api/chat.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `message=${encodeURIComponent(msg)}&csrf_token=${encodeURIComponent(
        csrfToken
      )}`,
      credentials: "same-origin",
    })
      .then(() => {
        message.value = "";
        grabMessages();
      })
      .catch((err) => console.error("Erreur envoi message:", err));
  });

  setInterval(grabMessages, 3000);
  grabMessages();
})();

// ===== AVATAR ===== //
function avatar() {
  const avatarInput = document.getElementById("AvatarInput");
  const avatarPreview = document.getElementById("avatarPreview");
  const profileAvatar = document.getElementById("profileAvatar");
  const avatarForm = document.getElementById("avatarForm");
  const avatarChg = document.getElementById("avatarChg");
  if (!avatarInput || !avatarForm) return;

  avatarInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        avatarPreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  avatarForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("../../api/avatar.php", { method: "POST", body: formData })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          profileAvatar.src = data.path + "?t=" + new Date().getTime();
          const modal = bootstrap.Modal.getInstance(
            document.getElementById("avatarModal")
          );
          modal.hide();
          avatarChg.textContent = data.success;
          avatarChg.className = "alert alert-success d-block";
          setTimeout(() => avatarChg.classList.add("d-none"), 3000);
        } else if (data.error) {
          avatarChg.textContent = data.error;
          avatarChg.className = "alert alert-danger d-block";
          setTimeout(() => avatarChg.classList.add("d-none"), 3000);
        }
      })
      .catch((err) => console.error(err));
  });
}

// ===== Dés ===== //

// Unique //
function rollDice(faces) {
  return Math.floor(Math.random()*faces) +1;
}

// Multiple //
function rollMultipleDice(diceArray) {
let total = 0;
let details = [];

diceArray.forEach( d => {
  for (let i=0; i < d.count; i++) {
  const roll = rollDice(d.faces);
  details.push({faces: d.faces, roll});
  total+=roll;
  }
});
return {total, details};
}

// Ajout Modificateurs //
  function addModifiers(total, modifiersArray) {
   let modifiersTotal = 0;
  
   modifiersArray.forEach(m => {
     modifiersTotal+=m;
 });

 const finalTotal = total+modifiersTotal;
 
  return finalTotal;
}

// Fonction complète //
function fullRoll(diceArray, modifiersArray) {
 const roll = rollMultipleDice(diceArray);
 const totalFinal = addModifiers(roll.total, modifiersArray);
return { Total: totalFinal, Details: roll.details};
}

// Interactions boutons //
function clickdice () {
  const dice = document.querySelectorAll("#game_menu button");
  const resultat = document.getElementById('result');

dice.forEach(btn => {
  btn.addEventListener("click", () => {
    if(btn.id === "toggle_button") return;
    
    const faces = parseInt(btn.textContent.slice(1));
    const diceArray = [{ faces, count: 1 }];

    const roll = fullRoll(diceArray, []);

    const rolldetail = roll.Details.map(x => `D${x.faces}: ${x.roll}`).join('\n');

    resultat.textContent = `Total: ${roll.Total} / Détails: ${rolldetail}`;
  })
})
}


// ====== SONDAGE ===== //
// Vote
function vote (e) {
     e.preventDefault();

   const Voter = document.getElementById("Votesubmit");
   const voteResults = document.getElementById('voteResults');
   const votes = [...document.querySelectorAll('input[name="vote[]"]:checked')]
   const voteValues = votes.map(input => input.value);
   const dates = document.getElementById('dates');

 if (!voteResults || !dates) return;


 fetch("../../api/sondage.php", {
   method: "POST",
   headers: {
     "Content-Type": "application/json",
     "CSRF-Token": csrfToken
   },
   body: JSON.stringify({
     vote: voteValues
   })
   })

   .then(response => response.json())
   .then(data => {
     voteResults.innerHTML = '';
     data.forEach(item => {
       voteResults.innerHTML += `<p>${item.description} : ${item.votes}</p>`;
     });
 })
   .catch(error=>console.error(error));

  votes.forEach(element => element.checked = false);
   Voter.innerText = "Voté !"
   Voter.setAttribute('disabled', true)

   loadResults();
 }

// Affichage résultats
function loadResults() {
 const dates = document.getElementById('dates');
 const dateSelected = document.getElementById('dateSelected');
 const pollMonth = document.getElementById('pollMonth');
 const voteResults = document.getElementById('voteResults');


 fetch("../../api/sondage.php", {
   method: "GET",
   headers: {
     "Content-Type": "application/json",
     "CSRF-Token": csrfToken
   }
 })
   .then(response => response.json())
   .then(data => {
       dates.innerHTML = '';
          data.forEach(item => {
       dates.innerHTML += `<label><input type="checkbox" name="vote[]" value="${item.id}"> ${item.description}</label> <br>`;
       voteResults.innerHTML += `<p>${item.description} : ${item.votes}</p>`;

     });

     if (data.length > 0) {
       const best = data.reduce((prev, current) => (prev.votes > current.votes) ? prev : current);
       dateSelected.innerHTML = `<h1>Prochaine séance</h1><br><p>${best.description}</p><br><p>21h00</p>`;
      const fullDate = data[0].description;
      const parts = fullDate.split(" ");
      const month = parts[2];
      pollMonth.textContent = month;
     }

 })
   .catch(error=>console.error(error));
 }

// ====== ADMIN ACTIONS ===== //
function actions() {
const tableau = document.getElementById("users")
const alertDiv = document.getElementById("alert")

if (!tableau || !alert) {
  return
}

fetch("../../api/admin_actions.php", {
  method: "GET",
  headers: {
    "Content-Type": "application/json",
    "CSRF-Token": csrfToken
  }
})
.then(response => response.json())
.then(data => {
  data.forEach(user => {
tableau.innerHTML += `<tr data-user-id="${user.id}"><th scope="row">${user.id}</th><td>${user.username}</td><td>${user.email}
</td><td>${user.role_name}</td><td><button class="resetmdp" data-user-id="${user.id}">Réinitialiser MdP</button>
<button class="del_user" data-user-id="${user.id}">Supprimer utilisateur</button></tr>`})
})
.catch(error=>console.error(error));

// Reset Mdp //
document.querySelectorAll('.resetmdp').forEach(btn => {
  btn.addEventListener("click", (e) => {
    const userId = e.target.closest('tr').dataset.userId;

    fetch("../../api/admin_actions.php",  {
      method: "POST",
      headers: {
    "Content-Type": "application/json",
    "CSRF-Token": csrfToken      
    },
      body: JSON.stringify({action: "reset_password", user_id: userId})
    })
    .then(r => r.json())
    .then(r => {
 if (r.error) {
      alertDiv.innerHTML = r.error;
      alertDiv.className = "alert alert-danger";
    } else if
      (r.success) {
        alertDiv.innerHTML = r.success;
        alertDiv.className = "alert alert-success";
      }
  });
  });
});
}

// Suppr user //
document.querySelectorAll('.del_user').forEach(btn => {
  btn.addEventListener("click", (e) => {
    const userId = e.target.closest('tr').dataset.userId;
    const row = e.target.closest('tr');

    
    fetch("../../api/admin_actions.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "CSRF-Token": csrfToken
      },
      body: JSON.stringify({action: "delete_user", user_id: userId})
    })
    .then(r => r.json())
    .then(r => {
 if (r.error) {
      alertDiv.innerHTML = r.error;
      alertDiv.className = "alert alert-danger";
    } else if
      (r.success) {
        alertDiv.innerHTML = r.success;
        alertDiv.className = "alert alert-success";
        row.classList.add('user-deleted');
        row.querySelectorAll('button').forEach(b => b.disabled = true);
      }
  });
  });
});



// ====== APPEL DE FONCTION ===== //
document.addEventListener("DOMContentLoaded", function () {
  togglemenu();
  title();
  avatar();
  loadResults();
  actions();
  gameMenu();
  clickdice();
  window.addEventListener("resize", title);


  const Voter = document.getElementById("Votesubmit");
  if (Voter) {
    Voter.addEventListener("click", vote);
  }
});
