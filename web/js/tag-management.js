let nbTags = parseInt(document.getElementById('nb-tags-input').value)

const tagManagement = document.getElementById('tag-management')
const tagInput = document.getElementById('tag-input')
const fullTagList = document.getElementsByClassName('tag-management--tag-list')[0]
const smallTagList = document.getElementById('tag-preview--list')

function isOverflown(element) {
    return element.scrollHeight > element.clientHeight || element.scrollWidth > element.clientWidth;
}

const countOverflownElements = () => {
    let count = 0
    const box = smallTagList.getBoundingClientRect()

    for (element of document.getElementById('tag-preview--list').children) {
        const elementBox = element.getBoundingClientRect()
        if (elementBox.right > box.right || elementBox.bottom > box.bottom) {
            count++
        }
    }
    console.log("counted : " + count)
    return count
}

const updateTagList = () => {
    console.log("update")
    console.log(nbTags)
    if (nbTags > 0) {
        document.getElementById('tag-example-1').style.display = 'none'
        document.getElementById('tag-example-2').style.display = 'none'
    } else {
        document.getElementById('tag-example-1').style.display = ''
        document.getElementById('tag-example-2').style.display = ''
    }

    console.log(isOverflown(smallTagList))
    if (isOverflown(smallTagList)) {
        let count = countOverflownElements()
        document.getElementById('tags--count').innerHTML = `(+${count})`
        document.getElementById('tags--count').style.display = 'flex'
    } else {
        document.getElementById('tags--count').style.display = 'none'
    }

    document.getElementById('nb-tags-input').value = nbTags
}

const openTagManagement = () => {
    tagManagement.style.visibility = 'visible'
    tagManagement.style.opacity = '1'
    console.log("coucou")
}

const closeTagManagement = async () => {
    tagManagement.style.opacity = '0'
    await pause(300)
    tagManagement.style.visibility = 'hidden' 
}

const addTag = () => {
    console.log(tagInput.value)
    if (tagInput.value.length > 0) {
        nbTags++
        const tag = document.createElement('div')
        tag.classList.add('rectangle')
        tag.classList.add('rectangle--blue')
        tag.id = 'tag-' + nbTags  
        tag.innerHTML = tagInput.value
        tag.classList.add('tag-rectangle')

        fullTagList.appendChild(tag)

        const smallTag = tag.cloneNode(true)
        smallTag.id = 'small-tag-' + nbTags
        smallTagList.appendChild(smallTag)

        const inputTagForForm = document.createElement('input')
        inputTagForForm.type = 'hidden'
        inputTagForForm.name = 'tag-' + nbTags
        inputTagForForm.id = 'input-tag-' + nbTags
        inputTagForForm.value = tagInput.value.replace(/[&<>"']/g, function (m) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            }[m];
        });
        tagManagement.appendChild(inputTagForForm)

        smallTag.addEventListener('click', ()  => {
            for (let i = parseInt(tag.id.split('-')[1]); i < nbTags; i++) {
                document.getElementById('tag-' + (i + 1)).id = 'tag-' + i
                document.getElementById('small-tag-' + (i + 1)).id = 'small-tag-' + i
                document.getElementById('input-tag-' + (i + 1)).name = 'tag-' + i
                document.getElementById('input-tag-' + (i + 1)).id = 'input-tag-' + i
            }

            fullTagList.removeChild(tag)
            smallTagList.removeChild(smallTag)
            tagManagement.removeChild(inputTagForForm)

            nbTags--
            updateTagList()
        })

        tag.addEventListener('click', ()  => {
            for (let i = parseInt(tag.id.split('-')[1]); i < nbTags; i++) {
                document.getElementById('tag-' + (i + 1)).id = 'tag-' + i
                document.getElementById('small-tag-' + (i + 1)).id = 'small-tag-' + i
                document.getElementById('input-tag-' + (i + 1)).name = 'tag-' + i
                document.getElementById('input-tag-' + (i + 1)).id = 'input-tag-' + i
            }

            fullTagList.removeChild(tag)
            smallTagList.removeChild(smallTag)
            tagManagement.removeChild(inputTagForForm)
            nbTags--
            updateTagList()
        })

        tagInput.value = ''
        updateTagList()
    }
}

document.getElementById('open-tag-management').addEventListener('click', () => {
    openTagManagement()
})

document.getElementById('tags--count').addEventListener('click', () => {
    openTagManagement()
})

document.getElementById('close-tag-management').addEventListener('click', () => {
    closeTagManagement()
})

for (element of document.querySelectorAll('input')) {
    if (element.id !== 'tag-input') {
        element.addEventListener('focus', () => {
            closeTagManagement()
        })
    }
}

for (element of document.querySelectorAll('textarea')) {
    if (element.id !== 'tag-input') {
        element.addEventListener('focus', () => {
            closeTagManagement()
        })
    }
}

document.getElementById('add-tag-button').addEventListener('click', () => {
    addTag()
})

// on window resize
window.addEventListener('resize', () => {
    updateTagList()
})

for (let element of document.getElementsByClassName('tag-rectangle')) {
    element.addEventListener('click', ()  => {
        let nId = parseInt(element.id.split('-')[element.id.split('-').length - 1])
        
        console.log("nId = " + nId);

        console.log(document.getElementById('tag-' + nId));
        console.log(document.getElementById('small-tag-' + nId));
        console.log(document.getElementById('input-tag-' + nId));
        fullTagList.removeChild(document.getElementById('tag-' + nId))
        smallTagList.removeChild(document.getElementById('small-tag-' + nId))
        tagManagement.removeChild(document.getElementById('input-tag-' + nId))

        for (let i = nId; i < nbTags; i++) {
            document.getElementById('tag-' + (i + 1)).id = 'tag-' + i
            document.getElementById('small-tag-' + (i + 1)).id = 'small-tag-' + i
            document.getElementById('input-tag-' + (i + 1)).name = 'tag-' + i
            document.getElementById('input-tag-' + (i + 1)).id = 'input-tag-' + i
        }

        nbTags--
        updateTagList()
    })
}