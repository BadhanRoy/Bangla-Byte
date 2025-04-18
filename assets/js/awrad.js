
const playerData = {
    name: "",
    position: "",
    club: "",
    matches: "",
    goals: "",
    minutes: "",
    imageSrc: "" 
};

document.getElementById("playerName").textContent = playerData.name;
document.getElementById("playerPosition").textContent = playerData.position;
document.getElementById("playerClub").textContent = playerData.club;
document.getElementById("playerMatches").textContent = playerData.matches;
document.getElementById("playerGoals").textContent = playerData.goals;
document.getElementById("playerMinutes").textContent = playerData.minutes;

const playerImage = document.getElementById("playerImage");
playerImage.src = playerData.imageSrc;
playerImage.alt = playerData.name + "'s image";