var data;
async function updateJson(){
    
    const a = await fetch("../php/Recherche.php");
    const b = await a.text();
    data = b;
}
updateJson();