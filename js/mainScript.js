const header = document.querySelector("section");
const sectionOne = document.querySelector(".homeSection");

const sectionOneOptions = {
    rootMargin: "-200px 0px 0px 0px"
};

const sectionOneObserver = new IntersectionObserver(function(
        entries,
        sectionOneObserver
    ) {
        entries.forEach(entry => {
            if (!entry.isIntersecting) {
                header.classList.add("navbarScrolled");
            } else {
                header.classList.remove("navbarScrolled");
            }
        });
    },
    sectionOneOptions);

sectionOneObserver.observe(sectionOne);
let isMem1Clicked =false;
const mem1 = document.getElementById('mem1');
const mem1Img = document.getElementById('mem1Img');
const mem1Icons = document.getElementsByClassName('mem1Icon');
mem1.addEventListener('click', function(e) {
    if(e.target==mem1Img){
        if(!isMem1Clicked){
            for( let i=0 ; i<mem1Icons.length ; i++ ){
                mem1Icons[i].style.display='block';
                console.log( mem1Icons[i])
            }
            isMem1Clicked=!isMem1Clicked;
        }
        else{
            for( let i=0 ; i<mem1Icons.length ; i++ ){
                mem1Icons[i].style.display='none';
                console.log( mem1Icons[i])
            }
            isMem1Clicked=!isMem1Clicked;
        }
        
    }   
})
let isMem2Clicked =false;
const mem2 = document.getElementById('mem2');
const mem2Img = document.getElementById('mem2Img');
const mem2Icons = document.getElementsByClassName('mem2Icon');
mem2.addEventListener('click', function(e) {
    if(e.target==mem2Img){
        if(!isMem2Clicked){
            for( let i=0 ; i<mem2Icons.length ; i++ ){
                mem2Icons[i].style.display='block';
                console.log( mem2Icons[i])
            }
            isMem2Clicked=!isMem2Clicked;
        }
        else{
            for( let i=0 ; i<mem2Icons.length ; i++ ){
                mem2Icons[i].style.display='none';
                console.log( mem2Icons[i])
            }
            isMem2Clicked=!isMem2Clicked;
        }
        
    }   
})

