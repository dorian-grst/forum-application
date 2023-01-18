let visibilitySwitcher = document.getElementById('visibility-switcher')
let visibilityInput = document.getElementById('visibility-input')
let clickable = true

visibilitySwitcher.style.transition = 'transform 0.8s'


const normalX = () => {
    visibilitySwitcher.style.transitionDuration = '0'
    visibilitySwitcher.style.transform = ''
}

let visibilityPublic = true

const animationSwitch = () => {
    clickable = false
    if (visibilityPublic) {
        visibilitySwitcher.style.transform = 'rotateX(360deg)'
    } else {
        visibilitySwitcher.style.transform = 'rotateX(0deg)'
    }
}

async function switchVisibility() {
    if (!clickable) return

    console.log('click')

    animationSwitch()

    await pause(400)

    if (visibilityPublic) {
        visibilitySwitcher.querySelector('div').textContent = 'Privé'
        visibilitySwitcher.querySelector('div').style.color = '#c22b2b'
        visibilitySwitcher.querySelector('img').src = '../web/svg/private.svg'
        visibilityInput.value = 'private'
        visibilityPublic = false
    } else {
        visibilitySwitcher.querySelector('div').textContent = 'Public'
        visibilitySwitcher.querySelector('div').style.color = '#3D5AF1'
        visibilitySwitcher.querySelector('img').src = '../web/svg/public.svg'
        visibilityInput.value = 'public'
        visibilityPublic = true
    }

    clickable = true
}


visibilitySwitcher.addEventListener('click', switchVisibility)

const start = async () => {
    await pause(600)
    switchVisibility()
    await pause(800)
    switchVisibility()
    await pause(800)
}

// start()