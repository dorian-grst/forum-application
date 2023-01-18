let typeOfPage = document.getElementById('type-of-page').value
console.log(typeOfPage)
let button = document.getElementById(`${typeOfPage}-question`)

button.querySelector('rect').style.transition = '1s'

function checker() {
    console.log("lolilol");
    if (checkValidity()) {
        button.classList.add('valid')
        button.classList.remove('not-valid')
        button.querySelector('rect').style.fill = '#7583EF'
    } else {
        button.classList.remove('valid')
        button.classList.add('not-valid')
        button.querySelector('rect').style.fill = '#C7CFFA'
    }
}

function checkValidity() {
    for (element of document.querySelectorAll('[required]')) {
        if (element.value === '') {
            return false
        }
    }
    return true
}

for (element of document.querySelectorAll('[required]')) {
    element.addEventListener('keyup', () => {
        checker()
    })
}


window.onload = () => {
    checker()
}