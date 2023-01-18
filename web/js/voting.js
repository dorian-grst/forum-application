console.log('voting.js loaded');

function appearVotePannel(pannel) {
    pannel.style.display = 'flex'
}

function disappearVotePannel(pannel) {
    pannel.style.display = 'none'
}

function removeSelection(pannel) {
    const liste = pannel.querySelectorAll('.selected')
    const btnVote = pannel.parentNode.querySelector('.vote-button')
    btnVote.src = './svg/vote-btn.svg'
    console.log(btnVote);
    liste.forEach(element => {
        element.classList.remove('selected')
    })
}

const listBtn = document.getElementsByClassName('vote-button')
const listVoteYes = document.getElementsByClassName('vote-yes')
const listVoteNo = document.getElementsByClassName('vote-no')
const listVoteBigYes = document.getElementsByClassName('vote-big-yes')
 function updateSendVotesBtn() {
    const btnSendVotes = document.getElementById('send-votes')
    if (document.querySelectorAll('.selected').length === 0) {
        btnSendVotes.style.opacity = 0
        setTimeout(() => {
            btnSendVotes.style.visibility = 'hidden'
        }, 300)
    } else {
        btnSendVotes.style.visibility = 'visible'
        btnSendVotes.style.opacity = 1
    }
}

for (let i = 0; i < listBtn.length; i++) {
    listBtn[i].addEventListener('click', function() {
        appearVotePannel(listBtn[i].parentNode.getElementsByClassName('vote-pannel')[0])
    })
}

for (let i = 0; i < listVoteYes.length; i++) {
    listVoteYes[i].addEventListener('click', function() {
        removeSelection(listVoteYes[i].parentNode)
        if (listVoteYes[i].parentNode.querySelector('input').value != 1) {
            listVoteYes[i].classList.add('selected')
            listVoteYes[i].parentNode.querySelector('input').value = 1
            listVoteYes[i].parentNode.parentNode.querySelector('.vote-button').src = './svg/like.svg'
        } else {
            listVoteYes[i].classList.remove('selected')
            listVoteYes[i].parentNode.querySelector('input').value = 0
        }
        // listVoteYes[i].parentNode.parentNode.querySelector('.vote-button').classList.add('selected')
        disappearVotePannel(listVoteYes[i].parentNode)
        updateSendVotesBtn()
    })
}

for (let i = 0; i < listVoteNo.length; i++) {
    listVoteNo[i].addEventListener('click', function() {
        removeSelection(listVoteNo[i].parentNode)
        if (listVoteNo[i].parentNode.querySelector('input').value != -1) {
            listVoteNo[i].classList.add('selected')
            listVoteNo[i].parentNode.querySelector('input').value = -1
            listVoteNo[i].parentNode.parentNode.querySelector('.vote-button').setAttribute('src', './svg/dislike.svg')
        } else {
            listVoteNo[i].classList.remove('selected')
            listVoteNo[i].parentNode.querySelector('input').value = 0
        }
        // listVoteNo[i].parentNode.parentNode.querySelector('.vote-button').classList.add('selected')listVoteBigYes[i].parentNode.parentNode.querySelector('.vote-button')
        disappearVotePannel(listVoteNo[i].parentNode)
        updateSendVotesBtn()
    })
}

for (let i = 0; i < listVoteBigYes.length; i++) {
    listVoteBigYes[i].addEventListener('click', function() {
        removeSelection(listVoteBigYes[i].parentNode)
        if (listVoteBigYes[i].parentNode.querySelector('input').value != 2) {
            listVoteBigYes[i].classList.add('selected')
            listVoteBigYes[i].parentNode.querySelector('input').value = 2
            listVoteBigYes[i].parentNode.parentNode.querySelector('.vote-button').src = './svg/superlike.svg'
        } else {
            listVoteBigYes[i].classList.remove('selected')
            listVoteBigYes[i].parentNode.querySelector('input').value = 0
        }
        // listVoteBigYes[i].parentNode.parentNode.querySelector('.vote-button').classList.add('selected')
        disappearVotePannel(listVoteBigYes[i].parentNode)
        updateSendVotesBtn()
    })
}

document.body.addEventListener('click', function(e) {
    if (e.target.className != 'vote-pannel' && e.target.className != 'vote-button') {
        const listPannel = document.getElementsByClassName('vote-pannel')
        for (let i = 0; i < listPannel.length; i++) {
            disappearVotePannel(listPannel[i])
        }
    }
})
