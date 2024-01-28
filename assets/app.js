import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css'

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉')


document.addEventListener("DOMContentLoaded",()=>{
    const image=document.getElementById("medecin_form_PHOTOS")
    const image_p=document.getElementById("image")

    image.addEventListener("change",()=>{
    let reader=new FileReader()
    reader.onload=function(e){
        image_p.src=e.target.result
        
    }
    reader.readAsDataURL(image.files[0])
})

})

document.addEventListener("DOMContentLoaded",()=>{
    const image=document.getElementById("medicament_form_PHOTOS")
    const image_p=document.getElementById("image")

    image.addEventListener("change",()=>{
    let reader=new FileReader()
    reader.onload=function(e){
        image_p.src=e.target.result
        
    }
    reader.readAsDataURL(image.files[0])
})

})
 