<script>

window.onscroll = function() {myFunction()};

var navbar = document.getElementById("nav-bottom");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
</script>