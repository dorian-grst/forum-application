let nbSections = parseInt(document.getElementById('nb-sections').value);

console.log(document.getElementById('nb-sections').value);

const sectionPattern = document.getElementById('section-1').cloneNode(true)

function changeNbSections(n) {
    console.log(nbSections);
    document.getElementById('nb-sections').value = n
}

const removeSection = (element) => {
    if (nbSections <= 1) { 
        alert('Vous devez avoir au moins une section.')
        return;
    }
    if (!Alerts.comfirm("Voulez vous vraiment supprimer la section ?")) return;
    if (nbSections > 1) {
        if (element.id === 'section-1')
            document.getElementById('section-2').classList.remove('new-section')


        for (let i = parseInt(element.id.split('-')[1]) + 1; i <= nbSections; i++) {
            let nextSection = document.getElementById('section-' + i)
            nextSection.id = 'section-' + (i - 1)
            nextSection.querySelector('label').textContent = 'Titre de la section n°' + (i - 1)
            nextSection.querySelector('input').name = 'titre-section-' + (i - 1)
            nextSection.querySelector('textarea').name = 'description-section-' + (i - 1)
        }
        nbSections--
        console.log(element)
        element.remove()
    }

    checker()
    changeNbSections(nbSections)
}

function addSection() {
    nbSections++;
    const newSection = sectionPattern.cloneNode(true)
    console.log(newSection)
    newSection.classList.add('new-section')
    newSection.id = 'section-' + nbSections

    topSection = newSection.getElementsByClassName('top-section')[0]
    topSection.querySelector('label').textContent = 'Titre de la section n°' + nbSections
    topSection.querySelector('svg').id = "delete-section-" + nbSections
    topSection.querySelector('svg').classList.add("delete-section")

    console.log("lol1")

    newSection.querySelector('input').value = ''
    newSection.querySelector('input').name = 'titre-section-' + nbSections
    newSection.querySelector('textarea').name = 'description-section-' + nbSections
    document.getElementById('section-1').parentNode.appendChild(newSection)

    console.log("lol2")

    newSection.getElementsByClassName('delete-section')[0].addEventListener('click', () => removeSection(newSection))

    checker()

    newSection.addEventListener('keyup', () => {
        checker()
    })
    changeNbSections(nbSections)
}

let once = () => {
    for (let i = 1; i <= nbSections; i++) {
        let section = document.getElementById('section-' + i)
        section.getElementsByClassName('delete-section')[0].addEventListener('click', () => removeSection(section))
    }
}

once()

document.getElementById('add-section').addEventListener('click', addSection)

// document.getElementById('remove-section').addEventListener('click', removeSection);