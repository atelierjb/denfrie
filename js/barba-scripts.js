// barba.use(barbaCss)

// barba.init({
//     transitions: [
//         {
//             name: "fade",
//             once () {},
//             beforeEnter ({ current, next, trigger }) {

//                 const headerLinks = document.querySelectorAll(".nav a")
//                 const href = next.url.path

//                 headerLinks.forEach(link => {
//                     if (link.getAttribute("href") === href) {
//                         link.classList.add("selected")
//                     } else {
//                         link.classList.remove("selected")
//                     }
                    
//                 })

//                 window.scrollTo({
//                     top: 0,
//                     behavior: "smooth"
//                 })
//             }
//         }
//     ]
// })
