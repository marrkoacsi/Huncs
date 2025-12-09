$(document).ready(function () {
    const cardWrapper = $('.cardWrapper');
    const cardList = $('.cardList');
    const originalCards = $('.card');
    const cardWidth = 340;
    const speed = 5500; // 7.5 másodperc
    const totalClones = 50;
    const randomize = true;
    
    // Hang inicializálása
    const crateSound = new Audio('sounds/crate_open.mp3');
    crateSound.preload = 'auto';
    let soundAllowed = false;

    // Engedélyezés első kattintáskor
    $(document).one('click', function() {
        soundAllowed = true;
        crateSound.muted = false;
        // Próbáljuk meg lejátszani a hangot azonnal
        crateSound.play().then(() => {
            crateSound.pause();
            crateSound.currentTime = 0;
        }).catch(e => console.log("Hang előzetes betöltése sikertelen:", e));
    });

    // Klónozd a kártyákat
    for (let i = 0; i < totalClones; i++) {
        originalCards.clone().appendTo(cardList);
    }

    function spin(callback) {
        if (soundAllowed) {
            crateSound.currentTime = 0; // Mindig az elejétől kezdjük
            crateSound.play().catch(e => console.log("Hang lejátszási hiba:", e));
            
            // Automatikus leállítás az animáció végén
            setTimeout(() => {
                crateSound.pause();
                crateSound.currentTime = 0;
            }, speed);
        }

        const totalCards = $('.card').length;
        let distance = 20 * cardWidth;

        if (randomize) {
            distance = Math.floor(Math.random() * originalCards.length * 5);
            distance += originalCards.length * 10;
            const rand = Math.floor((Math.random() * 100) + 1);
            distance *= rand;
        }

        const newMargin = -(distance);

        cardList.css('transition', `margin-left ${speed/1000}s ease-out`);
        cardList.css('margin-left', newMargin);

        setTimeout(function() {
            if (typeof callback === "function") {
                callback(newMargin);
            }
        }, speed);
    }

    $('#spin').click(function () {
        // Engedélyezzük a hangot, ha még nem tettük
        if (!soundAllowed) {
            soundAllowed = true;
            crateSound.muted = false;
        }

        cardList.css('transition', 'none');
        cardList.css('margin-left', '0');
        
        setTimeout(function() {
            spin(function (finalMargin) {
                const allCards = $('.card');
                const visibleIndex = Math.abs(Math.round(finalMargin / cardWidth)) % allCards.length;
                const visibleCard = allCards.eq(visibleIndex);
                const cardId = visibleCard.data('card-id');
                const cardText = visibleCard.text().trim();

                sessionStorage.setItem('selectedCard', cardId);
                alert("Gratulálunk, kinyitottad: " + cardText + "!");

                fetch("save_card.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({ selectedCard: cardId })
                })
                .then(response => response.text())
                .then(data => console.log("PHP Response:", data));
            });
        }, 10);

        return false;
    });
});