var falling = false;

// Sorting Algorithm
function sortArray(unsortedArray){
  unsortedArray = Array.prototype.slice.call(unsortedArray, 0);

  var mylist = document.getElementById('middle-col');
  var listitems = [];

  for (i = 0; i < unsortedArray.length; i++) {
    listitems.push(unsortedArray[i]);
  }

  listitems.sort(function(a, b) {
    var compA = a.getAttribute('id').toUpperCase();
    var compB = b.getAttribute('id').toUpperCase();
    return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
  });

  return listitems;
}

function onCardClick() {
  const allDisplayedCards = sortArray(document.getElementsByClassName('fact-card-display'));

//   console.log(this.id);
  for (j = 0; j < allDisplayedCards.length; j++) {
    if (j < parseInt(this.id)) {
      allDisplayedCards[j].className = "fact-card-display fact-card-stack fact-card-open";
    }
    else {
      allDisplayedCards[j].className = "fact-card-display fact-card-stack";
    }

  }
}

function oneCardDblClick(query) {
  const allDisplayedCards = sortArray(document.getElementsByClassName('fact-card-display'));
  if (query.matches) { // If media query matches
    for (j = 0; j < allDisplayedCards.length; j++) {
      allDisplayedCards[j].addEventListener('click', onCardDoubleClick);
    }
  } else {
    for (j = 0; j < allDisplayedCards.length; j++) {
      allDisplayedCards[j].removeEventListener('click', onCardDoubleClick);
    }
  }
}
    

function onCardFocus() {
  const allDisplayedCards = sortArray(document.getElementsByClassName('fact-card-display'));
  const card = this.parentNode;

//   console.log(card.id);
  for (j = 0; j < allDisplayedCards.length; j++) {
    if (j < parseInt(card.id)) {
      allDisplayedCards[j].className = "fact-card-display fact-card-stack fact-card-open";
    }
    else {
      allDisplayedCards[j].className = "fact-card-display fact-card-stack";
    }
  }

  // Press any key to play the card
  card.addEventListener('keypress', onCardDoubleClick);
}

function onCardDoubleClick() {
  if (!falling) {
    const allDisplayedCards = sortArray(document.getElementsByClassName('fact-card-display'));
    const allHiddenCards = document.getElementsByClassName("fact-card-hidden");

    var randIndex = Math.floor(Math.random() * allHiddenCards.length);
    var randDiv = allHiddenCards[randIndex];

    this.style.transform = 'translateY(150%)';
    this.removeEventListener("dblclick", onCardDoubleClick);
    this.removeEventListener("click", onCardClick);

    var randDivId = randDiv.id;
    randDiv.id = this.id;
    randDiv.style.zIndex = (parseInt(randDiv.id)).toString();

    falling = true;

    setTimeout(() => {

      if (randDiv.id == "8-dis-card"){randDiv.className = "fact-card-display fact-card-stack";}
      else {randDiv.className = "fact-card-display fact-card-stack fact-card-open";}

    }, 500);


    setTimeout(() => {
      this.id = randDivId;
      this.className = "fact-card-fall fact-card-hidden";
      this.removeAttribute('style');
      onceClickedAnimation();
      falling = false;
    }, 1000);
  }
}

// Shows Cards when clicked once
function onceClickedAnimation() {
  const allDisplayedCards = sortArray(document.getElementsByClassName('fact-card-display'));

  
  for (i = 0; i < (allDisplayedCards.length - 1); i++) {
    allDisplayedCards[i].removeEventListener("click", onCardDoubleClick);
    allDisplayedCards[i].addEventListener('click', onCardClick);
    allDisplayedCards[i].lastChild.addEventListener('focus', onCardFocus);
  }
  twiceClickedAnimation();
  var query = window.matchMedia("(max-width: 760px)");
  oneCardDblClick(query); // Call listener function at run time
  query.addListener(oneCardDblClick); // Attach listener function on state changes
}

// Makes cards drop down when double-clicked
function twiceClickedAnimation() {
  const allDisplayedCards = sortArray(document.getElementsByClassName('fact-card-display'));

  for (i = 0; i < allDisplayedCards.length; i++) {
    allDisplayedCards[i].addEventListener('dblclick', onCardDoubleClick);
  }
}

onceClickedAnimation();

firstCard = document.getElementById("1-dis-card");
firstCard.classList += " fact-card-open";