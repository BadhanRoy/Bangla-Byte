// Sample player data 
const players = {
    forwards: [
        { name: "Rakib", image: "assets/images/club/player/rakib.png" },
        { name: "Solaiman Diabate", image: "assets/images/club/player/diabate.png" },
        { name: "S. Boetang", image: "assets/images/club/boetang.png" }
    ],
    midfielders: [
        { name: "Miguel Figrera", image: "assets/images/club/player/miguel.png" },
        { name: "M. Muzaffar", image: "assets/images/club/player/muzaffar.png" },
        { name: "R. Fernandes", image: "assets/images/club/player/fernandes.png" }
    ],
    defenders: [
        { name: "Isa Faisal", image: "assets/images/club/player/isa.png" },
        { name: "Kamrul Islam", image: "assets/images/club/player/kamrul.png" },
        { name: "Topu Bormon", image: "assets/images/club/player/topu.png" },
        { name: "Ridoy", image: "assets/images/club/player/ridoy.png" }
    ],
    goalkeeper: [
        { name: "Mitul Marma", image: "assets/images/club/mitul.png" }
    ]
};

// Function to populate a line with players
function populateLine(lineClass, playersArray) {
    const line = document.querySelector(`.${lineClass}`);
    playersArray.forEach(player => {
        const playerDiv = document.createElement("div");
        playerDiv.classList.add("player");
        playerDiv.innerHTML = `
            <img src="${player.image}" alt="${player.name}">
            <span>${player.name}</span>
        `;
        line.appendChild(playerDiv);
    });
}

// Populate each line
populateLine("forwards", players.forwards);
populateLine("midfielders", players.midfielders);
populateLine("defenders", players.defenders);
populateLine("goalkeeper", players.goalkeeper);