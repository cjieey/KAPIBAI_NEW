/*===== SHOW NAVBAR  =====*/ 
const showNavbar = (toggleId, navId, bodyId, headerId) => {
    const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId);

    // Check if all variables exist
    if (toggle && nav && bodypd && headerpd) {
        // Function to toggle the navigation state
        const toggleNav = () => {
            nav.classList.toggle('show');
            toggle.classList.toggle('bx-x');
            bodypd.classList.toggle('body-pd');
            headerpd.classList.toggle('body-pd');
            // Update navigation state in localStorage
            localStorage.setItem('navOpen', nav.classList.contains('show'));
        };

        // Event listener for the menu bar toggle
        toggle.addEventListener('click', toggleNav);

        // Check if navigation state is stored in localStorage
        const navState = localStorage.getItem('navOpen');
        if (navState === 'true') {
            // If navigation state is open, show the navigation
            toggleNav();
        }
    }
};

showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');



/*===== LINK ACTIVE  =====*/ 
//  const linkColor = document.querySelectorAll('.nav__link')

//  function colorLink(){
//      if(linkColor){
//          linkColor.forEach(l=> l.classList.remove('active'))
//          this.classList.add('active')
//      }
//  }
//  linkColor.forEach(l=> l.addEventListener('click', colorLink));
