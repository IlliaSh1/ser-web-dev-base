const body = document.querySelector('body');
const header  = document.querySelector('header');
let unlock = true;
const timeout = 0;


// LOCK BODY SCROLL
function bodyScrollLock() {
    const scrillWidth = window.innerWidth - body.offsetWidth + 'px';
    body.style.paddingRight = scrillWidth;
    body.classList.add('body_hidden_scroll');
    unlock = false;
    setTimeout ( () => {
        unlock = false;
    }, timeout);
}

// UNLOCK BODY SCROLL
function bodyScrollUnlock() {
    setTimeout(() => {
        body.style.paddingRight = '0px';
        body.classList.remove('body_hidden_scroll');
    }, timeout);
    unlock = false;
    setTimeout( () => {
        unlock = true;
    }, timeout);
}



// HEADER MENU TOGGLE
const menuBtns = document.querySelectorAll(".menu-toggle");
for(let i = 0;i<menuBtns.length; i++) {
    const el = menuBtns[i];
    el.addEventListener("click", (e) => {
        // PIN HEADER
        header.classList.toggle('active');
        
        let curId = el.getAttribute("id");
        curId = curId.substring(1, curId.length);
        // console.log(curId);
        const curMenu = document.getElementById(curId);
        
        let burgerIcon = header.querySelector(".burger-menu");
        burgerIcon.classList.toggle("active");
        
        // const burgerIcon = curMenu.querySelector(".burger-menu"); 
        // burgerIcon.classList.toggle(".active");


        if(unlock == true) {
            bodyScrollLock();
        } else {
            bodyScrollUnlock();
        } 

        curMenu.classList.toggle("active");
        el.classList.toggle("active");
        e.preventDefault();
    })
}