function changeContent(content){
    if(content==="answer"){
        if(document.getElementsByClassName('content--question')[0].classList.contains('content--none')){
            document.getElementsByClassName('content--info')[0].classList.add('content--none')
            document.getElementsByClassName('content--answer')[0].classList.remove('content--none')
        } else if(document.getElementsByClassName('content--info')[0].classList.contains('content--none')){
            document.getElementsByClassName('content--question')[0].classList.add('content--none')
            document.getElementsByClassName('content--answer')[0].classList.remove('content--none')
        }
    } else if(content==="info"){
        if(document.getElementsByClassName('content--answer')[0].classList.contains('content--none')){
            document.getElementsByClassName('content--question')[0].classList.add('content--none')
            document.getElementsByClassName('content--info')[0].classList.remove('content--none')
        } else if(document.getElementsByClassName('content--question')[0].classList.contains('content--none')){
            document.getElementsByClassName('content--answer')[0].classList.add('content--none')
            document.getElementsByClassName('content--info')[0].classList.remove('content--none')
        }
    } else{
        if(document.getElementsByClassName('content--answer')[0].classList.contains('content--none')){
            document.getElementsByClassName('content--info')[0].classList.add('content--none')
            document.getElementsByClassName('content--question')[0].classList.remove('content--none')
        } else if(document.getElementsByClassName('content--info')[0].classList.contains('content--none')){
            document.getElementsByClassName('content--answer')[0].classList.add('content--none')
            document.getElementsByClassName('content--question')[0].classList.remove('content--none')
        }
    }
    console.log("coucou")
}
console.log("truc")
