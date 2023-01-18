let isVisible = false
let isInResp = false
let isSomewhere = false
let popup = document.getElementById('popup')
const btnOwo = document.getElementById('add-owo');
const btnUwu = document.getElementById('add-uwu');
let [nbVoters, nbCollaborateur] = document.getElementById('nb-voters-collaborators').value.split('-').map(x => parseInt(x));
let restVoters= [];
let restCollaborators= [];


console.log("vote" +  nbVoters);
nbCollaborateur = isNaN(nbCollaborateur) ? 0 : nbCollaborateur;

function addVoter(id){
    const button = document.querySelector(`#${id}`);
    const classes = button.getAttribute("class");

    const input=document.getElementById("allVoters");
    const inputCollab=document.getElementById("allContributors");

    const buttonCollab=document.getElementById(id+"_");
    const classCollab=buttonCollab.getAttribute("class");
    const lesVotants=document.getElementById("tag");
    let divResponsable=document.getElementById("listCollaborator");

    let voters = input.value.split('_').filter(x => x.length > 0) || [];
    let collabs = inputCollab.value.split('_');

    if (classes.includes('selected')){ //deselection
        button.setAttribute("class", classes.split('selected').join('').trim());
        voters = voters.filter(x => x != id);
        input.setAttribute("value" , voters.join('_'));

        supp("voter",lesVotants,id);
        nbVoters--;
        if(classCollab.includes('selected')){
            buttonCollab.setAttribute("class", classes.split('selected').join('').trim());
            collabs.push(id);
            inputCollab.setAttribute("value", voters.join('_'));
            nbCollaborateur--;
            supp("collaborator",divResponsable,id+"_");
        }
    } else{ //selection
        button.setAttribute("class", `${classes} selected`);
        voters.push(id);
        input.value = voters.join('_')
        nbVoters++;
        ajout("voter",lesVotants,id);
    }
}

function addContributor(id){
    const button = document.querySelector(`#${id}`);
    const classes = button.getAttribute("class");

    const input= document.getElementById("allContributors");

    const inputVoter=document.getElementById(id.substring(0,id.length-1));
    const classeVoter=inputVoter.getAttribute("class");

    let collabs = input.value.split('_').filter(x => x.length > 0);

    let divResponsable=document.getElementById("listCollaborator");

    if(classeVoter.includes('selected')){
        if (classes.includes('selected')) {
            button.setAttribute("class", classes.split('selected').join('').trim());
            collabs = collabs.filter(x => x != id);
            input.setAttribute("value", collabs.join('_'));
            nbCollaborateur--;
            supp("collaborator",divResponsable,id);


        } else {
            button.setAttribute("class", `${classes} selected`);
            collabs.push(id)
            input.value = collabs.join('_');
            nbCollaborateur++;
            ajout("collaborator",divResponsable,id);

        }
    }
}

async function hidePopup(){
    popup.style.opacity = 0;
    await pause(200);
    popup.style.display = "none";
    isVisible = false;
}

async function showPopup(id){
    console.log(`id = ${id}`);
    if ((isInResp || !isSomewhere) && id === 'add-owo') {
        document.querySelector('.create--votants').appendChild(popup)
        isInResp = false
        isSomewhere = true
    } else if ((!isInResp || !isSomewhere) && id === 'add-uwu') {
        document.querySelector('.create--infos--responsables--list').appendChild(popup)
        isInResp = true
        isSomewhere = true
    }
    popup.style.display = "flex";
    popup.style.opacity = 1;
    isVisible = true;
}

function showOWO() {
    showPopup('add-owo')
}

function showUWU() {
    showPopup('add-uwu')
}

document.getElementById('close-voters-adding').addEventListener('click', () => {
    hidePopup()
});

document.getElementById('add-uwu').addEventListener('click', async () => {
    console.log("uwu pipi");
    showUWU()
})

document.getElementById('add-owo').addEventListener('click', async () => {
    console.log("owo caca");
    showOWO()
})

function ajout(classe,idDiv,name,ancien){
    if(classe=="voter"){
        if(nbVoters<=3){
            let votant= document.createElement("div");
            votant.setAttribute("class","rectangle rectangle--blue");
            votant.setAttribute("id",name+"Tag");
            votant.innerHTML=name;
            idDiv.appendChild(votant);
        }else if(nbVoters==4){
            let rest=document.createElement("div");
            rest.setAttribute("id","rest");
            rest.setAttribute("class","rectangle rectangle--blue");
            rest.innerHTML="...";
            restVoters.push(name);
            console.log(restVoters);
            idDiv.appendChild(rest);
        }else if(nbVoters>4){
            restVoters.push(name);
            console.log(restVoters);
        }

    }else if(classe=="voter2"){
        let votant=document.getElementById(ancien);
        votant.setAttribute("class","rectangle rectangle--blue");
        votant.setAttribute("id",name+"Tag");
        votant.innerHTML=name;
    }else if(classe=="collaborator"){
        console.log('COLLAB', nbCollaborateur);
        if(nbCollaborateur<4){
            let collab = document.createElement("div");

            collab.id = name+"TagR";
            collab.className = "rectangle rectangle--purple";
            collab.innerHTML = name.substring(0, name.length - 1);
            console.log('CACA');
            console.log(collab);
            idDiv.appendChild(collab);
        }else if(nbCollaborateur==4){
            let rest=document.createElement("div");
            rest.setAttribute("id","restR");
            rest.setAttribute("class","rectangle rectangle--purple");
            rest.innerHTML="...";
            restCollaborators.push(name);
            console.log(restCollaborators);
            idDiv.appendChild(rest);
        }else if(nbVoters>4){
            restCollaborators.push(name);
            console.log(restCollaborators);
        }
    }else if(classe=="collaborator2"){
        let responsable=document.getElementById(ancien);
        responsable.setAttribute("class","rectangle rectangle--purple");
        responsable.setAttribute("id",name+"TagR");
        responsable.innerHTML=name;
    }
}


function supp(classe,div,name){
    if(classe=="voter"){
        if(nbVoters<=3){
            console.log(name);
            let sup=document.getElementById(name+"Tag");
            sup.remove();
        }
        if(nbVoters>=4){
            if(exist(name+"Tag")){
                ajout("voter2",div,restVoters[0],name+"Tag");
                restVoters.splice(0,1);
            }else{
                restVoters.splice(restVoters.indexOf(name),1);
            }

            if(restVoters.length==0){
                document.getElementById("rest").remove();
            }
            console.log(restVoters);
        }


   }else if(classe=="collaborator"){
        console.log(restCollaborators);
        if(nbCollaborateur<=2){
            let sup=document.getElementById(name+"TagR");
            sup.remove();
        }
        if(nbCollaborateur>=3){
            if(exist(name+"TagR")){
                ajout("collaborator2",div,restCollaborators[0],name+"TagR");
                restCollaborators.splice(0,1);
            }else{
                restCollaborators.splice(restCollaborators.indexOf(name),1);
            }

            if(restCollaborators.length==0){
                document.getElementById("restR").remove();
                console.log("restR doit etre sup");
            }
            console.log(restCollaborators);
        }
    }

}

function exist(id){
    return document.getElementById(id)!=null;
}

// const startAddVoter = async () => {
//     await pause(200);
//     popup.style.display = "flex";
// }
// startAddVoter()

