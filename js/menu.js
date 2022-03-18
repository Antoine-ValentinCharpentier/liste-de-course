var content = document.querySelector('#menu'); 
var button = document.querySelector('#sidebarbutton'); 
var overlay = document.querySelector('#overlay'); 
var activatedClass = 'sidebar-activated'; 		

button.addEventListener('click', function(e) { 
	e.preventDefault(); 

	if (content.parentNode.classList.contains(activatedClass)) //vérifier si ses parents ont la classe activé du click pour limiter tout problème dans le futur
	{
		content.parentNode.classList.remove(activatedClass); 
	}else{
		content.parentNode.classList.add(activatedClass);
	}
});

/* quitter le menu déroulant a partir de la touche échape*/
button.addEventListener('keydown', function(e) {
	if (content.parentNode.classList.contains(activatedClass)) //vérifier si ses parents ont la classe activé du click pour limiter tout problème dans le futur
	{
		if (e.repeat === false && e.which === 27) //on regarde la touche sélectioner
			content.parentNode.classList.remove(activatedClass); //on lui retire la sidebar+overlay
	}
});