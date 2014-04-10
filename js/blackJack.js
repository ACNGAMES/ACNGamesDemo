function playBlackJack(){
	//TODO Actualizar el credito
	getCoins();
	if(Number(act.gold)+Number(act.silver)>=0.5){
		$('#pagina_central').html($.View("views/blackJack.ejs"));
		initCredit  = (Number(act.gold)+Number(act.silver))*100;
		if ((Number(act.gold)+Number(act.silver))>1){
			initBet=100;
		}else{
			initBet=initCredit;
		}
		initGame();	
	}else{
		//TODO agregar un mensaje mejor
		alert('no posee credito para jugar');
	}
	
}

function reloadCrBJ(){
	credits=(Number(act.gold)+Number(act.silver))*100;
}
//=============================================================================
// Card and Stack Objects
//=============================================================================

//-----------------------------------------------------------------------------
// Card constructor function.
//-----------------------------------------------------------------------------

function Card(rank, suit) {

  this.rank = rank;
  this.suit = suit;

  this.createNode = cardCreateNode;
}

//-----------------------------------------------------------------------------
// cardCreateNode(): Returns a DIV node which can be used to display the card 
// on a page.
//-----------------------------------------------------------------------------

// Preload graphics.

var cardImg0 = new Image(); cardImg0.src= "graphics/cardback.gif";
var cardImg1 = new Image(); cardImg1.src= "graphics/jack.gif";
var cardImg2 = new Image(); cardImg2.src= "graphics/queen.gif";
var cardImg3 = new Image(); cardImg3.src= "graphics/king.gif";

function cardCreateNode() {

  var cardNode, frontNode, indexNode, spotNode, tempNode, textNode;
  var indexStr, spotChar;

  // This is the main node, a DIV tag.

  cardNode = document.createElement("DIV");
  cardNode.className = "card";

  // Build the front of card.

  frontNode = document.createElement("DIV");
  frontNode.className = "front";

  // Get proper character for card suit and change font color if necessary.

  spotChar = "\u00a0";
  switch (this.suit) {
    case "C" :
      spotChar = "\u2663";
      break;
    case "D" :
      frontNode.className += " red";
      spotChar = "\u2666";
      break;
    case "H" :
      frontNode.className += " red";
      spotChar = "\u2665";
      break;
    case "S" :
      spotChar = "\u2660";
      break;
  }

  // Create and add the index (rank) to the upper-left corner of the card.

  indexStr = this.rank;
  if (this.toString() == "")
    indexStr = "\u00a0";
  spotNode = document.createElement("DIV");
  spotNode.className = "index";
  textNode = document.createTextNode(indexStr);
  spotNode.appendChild(textNode);
  spotNode.appendChild(document.createElement("BR"));
  textNode = document.createTextNode(spotChar);
  spotNode.appendChild(textNode);
  frontNode.appendChild(spotNode);

  // Create and add spots based on card rank (Ace thru 10).

  spotNode = document.createElement("DIV");
  textNode = document.createTextNode(spotChar);
  spotNode.appendChild(textNode);
  if (this.rank == "A") {
    spotNode.className = "ace";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }
  if (this.rank == "3" || this.rank == "5" || this.rank == "9") {
    spotNode.className = "spotB3";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }
  if (this.rank == "2" || this.rank == "3") {
    spotNode.className = "spotB1";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }
  if (this.rank == "2" || this.rank == "3") {
    spotNode.className = "spotB5";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }
  if (this.rank == "4" || this.rank == "5" || this.rank == "6" ||
      this.rank == "7" || this.rank == "8" || this.rank == "9" ||
      this.rank == "10") {
    spotNode.className = "spotA1";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
    spotNode.className = "spotA5";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
    spotNode.className = "spotC1";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
    spotNode.className = "spotC5";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }
  if (this.rank == "6" || this.rank == "7" || this.rank == "8") {
    spotNode.className = "spotA3";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
    spotNode.className = "spotC3";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }
  if (this.rank == "7" || this.rank == "8" || this.rank == "10") {
    spotNode.className = "spotB2";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }
  if (this.rank == "8" || this.rank == "10") {
    spotNode.className = "spotB4";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }
  if (this.rank == "9" || this.rank == "10") {
    spotNode.className = "spotA2";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
    spotNode.className = "spotA4";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
    spotNode.className = "spotC2";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
    spotNode.className = "spotC4";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }

  // For face cards (Jack, Queen or King), create and add the proper image.

  tempNode = document.createElement("IMG");
  tempNode.className = "face";
  if (this.rank == "J")
    tempNode.src = "graphics/jack.gif";
  if (this.rank == "Q")
    tempNode.src = "graphics/queen.gif";
  if (this.rank == "K")
    tempNode.src = "graphics/king.gif";

  // For face cards, add suit characters to the upper-left and lower-right
  // corners.

  if (this.rank == "J" || this.rank == "Q" || this.rank == "K") {
    frontNode.appendChild(tempNode);
    spotNode.className = "spotA1";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
    spotNode.className = "spotC5";
    tempNode = spotNode.cloneNode(true);
    frontNode.appendChild(tempNode);
  }

  // Add front node to the card node.

  cardNode.appendChild(frontNode);

  // Return the card node.

  return cardNode;
}

//-----------------------------------------------------------------------------
// Stack constructor function.
//-----------------------------------------------------------------------------

function Stack() {

  // Create an empty array of cards.

  this.cards = new Array();

  this.makeDeck  = stackMakeDeck;
  this.shuffle   = stackShuffle;
  this.deal      = stackDeal;
  this.cardCount = stackCardCount;
}

//-----------------------------------------------------------------------------
// stackMakeDeck(n): Initializes a stack using 'n' packs of cards.
//-----------------------------------------------------------------------------

function stackMakeDeck(n) {

  var ranks = new Array("A", "2", "3", "4", "5", "6", "7", "8", "9",
                        "10", "J", "Q", "K");
  var suits = new Array("C", "D", "H", "S");
  var i, j, k;
  var m;

  m = ranks.length * suits.length;

  // Set array of cards.

  this.cards = new Array(n * m);

  // Fill the array with 'n' packs of cards.

  for (i = 0; i < n; i++)
    for (j = 0; j < suits.length; j++)
      for (k = 0; k < ranks.length; k++)
        this.cards[i * m + j * ranks.length + k] = new Card(ranks[k], suits[j]);
}

//-----------------------------------------------------------------------------
// stackShuffle(n): Shuffles a stack of cards 'n' times. 
//-----------------------------------------------------------------------------

function stackShuffle(n) {

  var i, j, k;
  var temp;

  // Shuffle the stack 'n' times.

  for (i = 0; i < n; i++)
    for (j = 0; j < this.cards.length; j++) {
      k = Math.floor(Math.random() * this.cards.length);
      temp = this.cards[j];
      this.cards[j] = this.cards[k];
      this.cards[k] = temp;
    }
}

//-----------------------------------------------------------------------------
// stackDeal(): Removes the first card in the stack and returns it.
//-----------------------------------------------------------------------------

function stackDeal() {

  if (this.cards.length > 0)
    return this.cards.shift();
  else
    return null;
}

//-----------------------------------------------------------------------------
// stackCardCount(): Returns the number of cards currently in the stack.
//-----------------------------------------------------------------------------

function stackCardCount() {

  return this.cards.length;
}

// ============================================================================
// Blackjack game.
// ============================================================================

// Constants.

var numPacks      =    8;
var numShuffles   =   10;

var maxSplits     =    3;

var minBet        =    50;
var maxBet        =  1000;
var initCredit;  
var initBet;

var dealTimeDelay =  750;

// Globals.

var deck;
var burnCard;

var dealer;
var player = new Array(maxSplits + 1);
var curPlayerHand, numPlayerHands;

var credits, defaultBet;
var creditsTextNode, defaultTextNode;

var dealRoundCounter;

// Initialize game on page load.

function initGame() {

  var i;

	
  // Locate credits and default bet text nodes on the page.

  creditsTextNode = document.getElementById("credits").firstChild;
  defaultTextNode = document.getElementById("default").firstChild;

  // Initialize player's credits and bet amount.

  credits    = initCredit;
  defaultBet = initBet;
  changeBet(0);
  updateBetDisplay(0);

  // Initialize card deck.
if(credits<minBet){
	document.forms["controls"].elements["deal"].disabled      = true;
	alert('No posee credito suficiente para jugar');
	
}
  deck = new Stack();
  newDeck();

  // Create dealer and player hands.

  dealer = new Hand("dealer");
  for (i = 0; i < player.length; i++)
    player[i] = new Hand("player" + i);
}

// ----------------------------------------------------------------------------
// Blackjack hand object.                    
// ----------------------------------------------------------------------------

Hand.prototype.leftIncr  =  2.5;  // For positioning cards.
Hand.prototype.topIncr   =  0.2;
Hand.prototype.rollEvery =  5;

function Hand(id) {

  this.cards = new Array();

  // Get page elements based on id.

  this.fieldNode     = document.getElementById(id);
  this.cardsNode     = document.getElementById(id + "Cards");
  this.scoreTextNode = document.getElementById(id + "Score").firstChild;
  if (id != "dealer") {
    this.betTextNode    = document.getElementById(id + "Bet").firstChild;
    this.resultTextNode = document.getElementById(id + "Result").firstChild;
  }

  this.reset      = handReset;
  this.addCard    = handAddCard;
  this.removeCard = handRemoveCard;
  this.getScore   = handGetScore;
  this.clearCards = handClearCards;

  // Initialize as an empty hand.

  this.reset();
}

function handReset() {

  // Remove any cards and initialize properties.

  this.clearCards();

  this.cards     = new Array();
  this.blackjack = false;
  this.split     = false;
  this.doubled   = false;
  this.surrender = false;
  this.left      = 0;
  this.top       = 0;

  this.scoreTextNode.nodeValue  = "\u00a0";
  if (this.betTextNode) {
    this.betTextNode.parentNode.className = "textBox dollars";
    this.betTextNode.nodeValue = "\u00a0";
  }
  if (this.resultTextNode)
    this.resultTextNode.nodeValue = "\u00a0";
}

function handAddCard(card, down) {

  var n;
  var node;

  // Add the given card to the hand.

  n = this.cards.length;
  this.cards[n] = card;

  // Create a card node for display, set as face down if requested.

  node = this.cards[n].createNode();
  if (down)
    node.firstChild.style.visibility = "hidden";

  // Add the card display to the associated card area on the page.

  node.style.left = this.left + "em";
  node.style.top  = this.top  + "em";
  this.cardsNode.appendChild(node);
  this.left += this.leftIncr;
  if (this.cards.length % this.rollEvery == 0)
    this.top = 0;
  else
    this.top += this.topIncr;
}

function handRemoveCard() {

  var card;

  // Remove the last card in the array and save it.

  card = null;
  if (this.cards.length > 0) {
    card = this.cards.pop();

    // Remove the card node from the display and reset position.

    this.cardsNode.removeChild(this.cardsNode.lastChild);
    this.left -= this.leftIncr;
    this.top  -= this.topIncr;
  }

  // Return the card.

  return card;
}

function handGetScore() {

  var i, total;

  total = 0;

  // Total card values counting Aces as one.

  for (i = 0; i < this.cards.length; i++)
    if (this.cards[i].rank == "A")
      total++;
    else {
      if (this.cards[i].rank == "J" || this.cards[i].rank == "Q" ||
          this.cards[i].rank == "K")
        total += 10;
      else
        total += parseInt(this.cards[i].rank, 10);
    }

  // Change as many ace values to 11 as possible.

  for (i = 0; i < this.cards.length; i++)
    if (this.cards[i].rank == "A" && total <= 11)
      total += 10;

  return total;
}

function handClearCards() {

  // Remove the card nodes in the associated card area.

  while (this.cardsNode.lastChild)
    this.cardsNode.removeChild(this.cardsNode.lastChild);
}

// ----------------------------------------------------------------------------
// Game functions.
// ----------------------------------------------------------------------------

function newDeck() {

  // Create a deck.

  deck.makeDeck(numPacks);
  deck.shuffle(numShuffles);

  // Set the burn card.

  burnCard = Math.round(Math.random() * 26) + 26;
}

function getNextCard() {

  // If there are no cards left, start a new deck.

  if (deck.cardCount() == 0) {
    alert("New Deck");
    newDeck();
  }

  return deck.deal();
}

function startRound() {
	

  var i;

  // Reset all hands.

  dealer.reset();
  for (i = 0; i < player.length; i++) {
    player[i].reset();
    if (i > 0)
      player[i].fieldNode.style.display = "none";
  }

  // Start with a single player hand.

  curPlayerHand  = 0;
  numPlayerHands = 1;

  // Enable/disable buttons.
	
  document.forms["controls"].elements["deal"].disabled      = true;
  document.forms["controls"].elements["increase"].disabled  = true;
  document.forms["controls"].elements["decrease"].disabled  = true;
  DisablePlayButtons();

  // If the burn card was reached, start a new deck.

  if (deck.cardCount() < burnCard) {
    alert("Nuevo Maso.");
    newDeck();
  }

  // Take the player's bet.

  player[0].bet = defaultBet;
  credits -= player[0].bet;
  updateBetDisplay(0);

  // Start dealing the cards.
  dealRoundCounter = 1;
  dealRound();
  	//TODO aca tengo que actualizar el credito
  	getCoins();
  	makeBetBJ(player[0].bet/100,'Jugo al Blackjack',false);
	reloadCrBJ();
	//console.log('UPDATE Credit:'+credits);
}

function dealRound()
{

  // Deal a card to the player or the dealer based on the counter.

  switch(dealRoundCounter)
  {
    case 1:
      player[0].addCard(getNextCard(), false);
      break;

    case 2:
      dealer.addCard(getNextCard(), true);
      break;

    case 3:
      player[0].addCard(getNextCard(), false);
      break;

    case 4:
      dealer.addCard(getNextCard(), false);
      break;

    default:

      // No more cards to deal, play the round.

      playRound();
      return;
      break;
  }

  // Update the player's score.

  if (player[0].getScore() == 21) {
    player[0].blackjack = true;
    player[0].scoreTextNode.nodeValue = "Blackjack";
  }
  else
    player[0].scoreTextNode.nodeValue = player[0].getScore();

  // Set a timer for the next call.

  dealRoundCounter++;
  setTimeout(dealRound, dealTimeDelay);
}

function playRound() {

  // If dealer's up card is an ace, offer insurance.

  if (dealer.cards[1].rank == "A")
    offerInsurance();

  // Check for dealer blackjack.

  if (dealer.getScore() == 21) {
    dealer.blackjack = true;
    dealer.scoreTextNode.nodeValue = "Blackjack";
  }

  // If player or dealer has blackjack, end the round.

  if (player[0].blackjack || dealer.blackjack) {
    endRound();
    return;
  }

  // Enable/disable buttons.

  if (canSplit() && (credits-defaultBet)>0)
    document.forms["controls"].elements["split"].disabled = false;
  if(credits-defaultBet>0)
  	document.forms["controls"].elements["double"].disabled    = false;
  document.forms["controls"].elements["surrender"].disabled = false;
  document.forms["controls"].elements["hit"].disabled       = false;
  document.forms["controls"].elements["stand"].disabled     = false;

  // Highlight the player's hand.

  addClassName(player[0].fieldNode, "activeField");
}

function offerInsurance() {

  var amount;

  // Offer insurance bet to player. This is a side bet so it's resolved here.
if(credits>(player[0].bet / 2)){
  if (confirm("Quiere pagar Seguro?")) {

    // Take half of player's current bet from credits.

    amount = player[0].bet / 2;
    credits -= amount;
	
    // If the dealer has blackjack, show the down card and pay player at 2 to 1.
	getCoins();
	makeBetBJ(amount/100, 'Blackjack apuesta a seguro',true);
	reloadCrBJ();
    if (dealer.getScore() == 21)
    {
      dealer.cardsNode.firstChild.firstChild.style.visibility = "";
      credits += player[0].bet;
      alert("El Crupier tiene Balckjack, ganaste " + formatDollar(player[0].bet));
      payBet(player[0].bet/100,'Blackjack Pago Seguro',true);
      reloadCrBJ();
    }
    else
      alert("El Crupier no tiene Blackjack, perdiste " + formatDollar(amount));

    // Update credits.

    updateBetDisplay(0);
  }
	//TODO Aca tengo que hacer update del credito
	//console.log('UPDATE CREDIT SEGURO '+ credits);
}
}

function playerSplit() {

  var m, n;
  var card, node;

  // Enable/disable buttons.

  DisablePlayButtons();

  // Update the number of player hands.

  m = curPlayerHand;
  n = numPlayerHands;
  numPlayerHands++;

  // Note the split.

  player[m].split = true;
  player[n].split = true;

  // Remove the second card from the current hand and add it to a new hand.

  card = player[m].removeCard();
  player[m].scoreTextNode.nodeValue = player[m].getScore();
  player[n].addCard(card, false);
  player[n].scoreTextNode.nodeValue = player[n].getScore();
  player[n].fieldNode.style.display = "";

  // Update bet and credits.

  player[n].bet = player[m].bet;
  credits -= player[n].bet;
  //TODO separa cartas
  getCoins();
  makeBetBJ(player[n].bet/100, 'Blackjack separa cartas',false);
  reloadCrBJ();
  updateBetDisplay(n);
  updateBetDisplay(n + 1);

  // Give the current hand a second card.

  setTimeout(playerHit, dealTimeDelay);
}

function playerDouble() {

  // Double the player's bet and deal a single card.

  player[curPlayerHand].bet *= 2;
  credits -= defaultBet;
  //TODO aca tengo que volve a apostar
  getCoins();
  makeBetBJ(defaultBet/100,'Dobla apuesta Blackjack',false);
  updateBetDisplay(curPlayerHand);
  player[curPlayerHand].doubled = true;
  player[curPlayerHand].top = 0;
  playerHit();
}

function playerSurrender() {

  // Unhighlight the player's hand.

  removeClassName(player[0].fieldNode, "activeField");

  // Note the surrender and end the round.

  player[0].surrender = true;
  endRound();
}

function playerHit() {

  var n, p;

  // Enable/disable buttons.

  DisablePlayButtons();
  document.forms["controls"].elements["hit"].disabled   = false;
  document.forms["controls"].elements["stand"].disabled = false;

  // Give the player another card and find total.

  n = curPlayerHand;
  player[n].addCard(getNextCard(), false);
  p = player[n].getScore();

  // If the player has busted, go to the next hand.

  if (p > 21) {
    player[n].scoreTextNode.nodeValue =  "Busted (" + p + ")";
    startNextHand();
    return;
  }
  else
    player[n].scoreTextNode.nodeValue = p;

  // If the player has reached 21, or is doubling down, go on to the next hand.

  if (p == 21 || player[n].doubled) {
    startNextHand();
    return;
  }

  // Handle second card on split hands.

  if (player[n].split && player[n].cards.length == 2) {

    // If Aces were split, go on to next hand.

    if (player[n].split && player[n].cards[0].rank == "A") {
        startNextHand();
        return;
    }

    // Enable/disable buttons.

    document.forms["controls"].elements["double"].disabled = false;
    if (canSplit())
      document.forms["controls"].elements["split"].disabled = false;
  }
}

function playerStand() {

  // Go on to the next hand.

  startNextHand();
}

function startNextHand() {

  // Unhighlight the current hand.

  removeClassName(player[curPlayerHand].fieldNode, "activeField");

  // Go on to the next player hand or the dealer.

  curPlayerHand++;
  if (curPlayerHand >= numPlayerHands) {
    startDealer();
    return;
  }
  else {
    addClassName(player[curPlayerHand].fieldNode, "activeField");

    // Enable/disable buttons.

    DisablePlayButtons();

    // Give a split hand a second card.

    if (player[curPlayerHand].split)
      setTimeout(playerHit, dealTimeDelay);
  }
}

function startDealer() {

  var i, allBusts;

  // Enable/disable buttons.

  DisablePlayButtons();

  // If player has busted on all hands, end the round.

  allBusts = true;
  for (i = 0; i < numPlayerHands; i++)
    if (player[i].getScore() <= 21)
      allBusts = false;
  if (allBusts) {
    endRound();
    return;
  }

  // Otherwise, highlight the dealer's hand, show the down card and score and
  // play the hand.

  addClassName(dealer.fieldNode, "activeField");
  dealer.cardsNode.firstChild.firstChild.style.visibility = "";
  dealer.scoreTextNode.nodeValue = dealer.getScore();
  setTimeout(playDealer, dealTimeDelay);
}

function playDealer() {

  var d;

  // Get and show the dealer's score.

  d = dealer.getScore();
  dealer.scoreTextNode.nodeValue = d;

  // If the dealer's total is less than 17, set up to deal another card.

  if (d < 17) {
    setTimeout(dealToDealer, dealTimeDelay);
    return;
  }

  // Check if the dealer busted.

  if (d > 21)
    dealer.scoreTextNode.nodeValue = "Se Paso (" + d + ")";

  // Dealer is done, unhighlight the hand and end the round.

  removeClassName(dealer.fieldNode, "activeField");
  endRound();
}

function dealToDealer() {

  // Give the dealer another card and check the result.

  dealer.addCard(getNextCard(), false);
  playDealer();
}

function endRound() {

  var i, d, p, tmp;

  // Enable/disable buttons.

  EnableBetButtons();
  DisablePlayButtons();

  // Fix for IE 6 rendering bug.

  if (navigator.userAgent.indexOf("MSIE 6") >= 0) {
    dealer.cardsNode.firstChild.style.backgroundImage = "none";
    dealer.cardsNode.firstChild.style.backgroundColor = "white";
  }

  // Show the dealer's down card and score.

  dealer.cardsNode.firstChild.firstChild.style.visibility = "";
  d = dealer.getScore();
  if (!dealer.blackjack && d <= 21)
    dealer.scoreTextNode.nodeValue = d;

  // Show result of each player hand and pay it off, if appropriate.
	var auxamount= 0;
  for (i = 0; i < numPlayerHands; i++) {
    p = player[i].getScore();
    if (player[i].surrender) {
      player[i].resultTextNode.nodeValue = "El Jugador se retiro";
      player[i].bet /= 2;
      credits += player[i].bet;
      auxamount=player[i].bet;
      
    }
    else if ((player[i].blackjack && !dealer.blackjack) ||
             (p <= 21 && d > 21) || (p <= 21 && p > d)) {
      player[i].resultTextNode.nodeValue = "El Jugador Gana";
      tmp = 2 * player[i].bet;
			
      // Blackjack pays 3 to 2.

      if (player[i].blackjack)
        tmp += player[i].bet / 2;

      player[i].bet = tmp;
      credits += player[i].bet;
      auxamount+= player[i].bet;
    }
    else if ((dealer.blackjack && !player[i].blackjack) ||
             p > 21 || p < d) {
      player[i].resultTextNode.nodeValue = "El jugador Pierde";
      addClassName(player[i].betTextNode.parentNode, "lost");
    }
    else {
      player[i].resultTextNode.nodeValue = "Empate";
      credits += player[i].bet;
      auxamount+= player[i].bet;
    }
    
  }
  //TODO aca tengo que actualizar el credito
  if(auxamount>0){
  	payBet(auxamount/100,'Blackjack Paga Apuesta',false);
  	
  }
  //console.log('UPDATE END Credit:'+credits);
  if(credits==minBet){
		defaultBet=minBet;
		changeBet(0);
		document.forms["controls"].elements["deal"].disabled = false;
	}else if(credits>=defaultBet){
	 	 document.forms["controls"].elements["deal"].disabled = false;
	}
	if(credits== 0){
		document.forms["controls"].elements["deal"].disabled = true;
	}
	reloadCrBJ();
	updateBetDisplay(0);
	creditsTextNode.nodeValue = "Credito: " + formatDollar(credits);
	
}

function canSplit() {

  var n;

  // Has the split limit has been reached?

  if (numPlayerHands > maxSplits)
    return false;

  // Check for a pair.

  n = curPlayerHand;
  if (player[n].cards[0].rank == player[n].cards[1].rank)
    return true;

  // Also, allow tens and face cards to match as a pair.

  if ((player[n].cards[0].rank == "10" ||
       player[n].cards[0].rank == "J"  ||
       player[n].cards[0].rank == "Q"  ||
       player[n].cards[0].rank == "K") &&
      (player[n].cards[1].rank == "10" ||
       player[n].cards[1].rank == "J"  ||
       player[n].cards[1].rank == "Q"  ||
       player[n].cards[1].rank == "K"))
    return true;

  return false;
}

function updateBetDisplay(n) {

  var s;

  // Display the current bet on the given hand.

  if (player[n]) {
    if (player[n].bet != null)
      s = "Apuesta: " + formatDollar(player[n].bet);
    else
      s = "\u00a0";
    player[n].betTextNode.nodeValue = s;
  }

  // Display current credits.
	
  creditsTextNode.nodeValue = "Credito: " + formatDollar(credits);
}

function formatDollar(n) {

  

  // Format the given number as a dollar amount for display.
  return n;
  
}

function changeBet(n) {

  // Increase or decrease the default bet.

  defaultBet += n;
  defaultBet = Math.max(Math.min(defaultBet, maxBet), minBet);
  defaultBet = defaultBet>credits?credits:defaultBet;
  defaultTextNode.nodeValue = "Mano: " + formatDollar(defaultBet);

  // Reset the increase/decrease buttons.

  EnableBetButtons();
}

function EnableBetButtons() {

  // Enable the increase and decrease bet buttons provided the current bet
  // amount is within the allowed min/max value.
 
  document.forms["controls"].elements["increase"].disabled = (defaultBet >= maxBet || defaultBet >= credits);
  document.forms["controls"].elements["decrease"].disabled = (defaultBet <= minBet || minBet >= credits);
}

function DisablePlayButtons() {

  // Disable all the buttons used for playing a hand.

  document.forms["controls"].elements["split"].disabled     = true;
  document.forms["controls"].elements["double"].disabled    = true;
  document.forms["controls"].elements["surrender"].disabled = true;
  document.forms["controls"].elements["hit"].disabled       = true;
  document.forms["controls"].elements["stand"].disabled     = true;
}


function toggleRules() {

  var el;

  // Display or hide the game rules text.

  el = document.getElementById("rulesBox");
  if (el.style.display == "") {
    el.style.display = "block";
    document.forms["controls"].elements["rules"].value = "Ocultar Reglas";
  }
  else {
    el.style.display = "";
    document.forms["controls"].elements["rules"].value = "Mostrar Reglas";
  }
}

function addClassName(el, name)
{
	// Remove the class name if it already exists in the element's class name
	// list.

	removeClassName(el, name);

	// Add the class name to the element's current list of class names.

	if (el.className.length > 0)
		name = " " + name;
	el.className += name;
}

function removeClassName(el, name)
{
	// If the element has no class names, exit.

	if (el.className == null)
		return;

	// Rebuild the list of class names on the element but exclude the specified
	// class name.

	var newList = new Array();
	var curList = el.className.split(" ");
	for (var i = 0; i < curList.length; i++)
		if (curList[i] != name)
			newList.push(curList[i]);
	el.className = newList.join(" ");
}
