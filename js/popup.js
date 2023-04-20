function popup_show(popup, rowId){
    document.querySelector("#"+popup).classList.add("show");
    document.querySelector('header').classList.add('blur');
    document.querySelector('main').classList.add('blur');
    if (popup == 'popup2'){
        document.getElementById('rowId').setAttribute('value', rowId);
        const childs = document.querySelector(`[rowid='${rowId}']`).children;
        const inputEdit = document.getElementsByClassName("input-edit");
        let childsEdit = [];
        for (let index = 0; index < childs.length; index++) {
            const element = childs[index];
            if (element.getAttribute("class") == "edit") {
                childsEdit.push(element.innerHTML);
            }
        }
        for (let index = 0; index < childsEdit.length; index++) {
            const element = childsEdit[index];
            let onForceCommeUnGrosProc = false;
            if (inputEdit[index].tagName == 'SELECT') {
                const selectOpt = inputEdit[index].children;
                for (let cpt = 0; cpt < selectOpt.length; cpt++) {
                    const elementBis = selectOpt[cpt];
                    if(elementBis.getAttribute('value') == element) {
                        onForceCommeUnGrosProc = true;
                        break;
                    }
                }
                if (onForceCommeUnGrosProc) { //Merci Sacha
                    document.querySelectorAll(`[value="${element}"]`)[inputEdit[index].getAttribute("id") == "typeUpt"].remove()
                    inputEdit[index].innerHTML += `<option value='${element}' selected>${element}</option>`;
                }
                continue;
            }
            inputEdit[index].setAttribute('value', element);
        }
    }
}

function popup_hide(popup){
    document.querySelector("#"+popup).classList.remove("show");
    document.querySelector('header').classList.remove('blur');
    document.querySelector('main').classList.remove('blur');
    document.getElementById('rowId').setAttribute('value', "");
}
