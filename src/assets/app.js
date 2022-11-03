/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';


import Lenis from '@studio-freight/lenis'


const lenis = new Lenis({
  duration: 1.2,
  easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // https://www.desmos.com/calculator/brs54l4xou
  direction: 'vertical', // vertical, horizontal
  gestureDirection: 'vertical', // vertical, horizontal, both
  smooth: true,
  mouseMultiplier: 1,
  smoothTouch: false,
  touchMultiplier: 2,
  infinite: false,
})

function raf(time) {
  lenis.raf(time)
  requestAnimationFrame(raf)
}

requestAnimationFrame(raf)


const userDropdown = document.querySelector('.user-dropdown')
const userIcon = document.querySelector('.user-icon')

function toggleUserDropdown(){
  if (userDropdown.classList.contains('user-dropdown-active')){
    userDropdown.classList.remove('user-dropdown-active')
  } else { 
    userDropdown.classList.add('user-dropdown-active')
  }
}

userIcon.addEventListener('click', toggleUserDropdown)
window.addEventListener('click', event => {
  if (event.target != userIcon && event.target != userDropdown && userDropdown.classList.contains('user-dropdown-active')){
    userDropdown.classList.remove('user-dropdown-active')
  }

})
