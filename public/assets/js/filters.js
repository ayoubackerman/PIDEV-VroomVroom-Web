window.onload = () => {
    const FiltersForm = document.querySelector("#filters");
   // console.log("clic");

    //na3mlou boucle sur les input
    document.querySelectorAll("#filters input").forEach(input => {
       input.addEventListener("change",() => {

           //recuperer les donnees du formulaire
           const Form = new FormData(FiltersForm);

           //je fabrique la "queryString"
           const Params = new URLSearchParams();

           Form.forEach((value , key) => {
               Params.append(key, value);
           })

           //on recupere l'url active
           const Url = new URL(window.location.href);

           //on lance la requete ajax
           fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
               headers : {
                   "X-Requested-With": "XMLHttpRequest"
               }
           }).then(response =>
               response.json()
           ).then(data => {
               // On va chercher la zone de contenu
               const content = document.querySelector("#content");

               // On remplace le contenu
               content.innerHTML = data.content;
               //history.pushState({}, null, Url.pathname + "?" + Params.toString());
           }).catch(e => alert(e));



       });
    });
}