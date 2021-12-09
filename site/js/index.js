const d = document;
var DisplayMenuBtn = d.getElementById("DisplayMenuBtn"), DisplayProductSubMenuBtn = d.getElementById("DisplayProductSubMenuBtn");

DisplayMenuBtn.addEventListener('click', displayMenu);
if(DisplayProductSubMenuBtn !== null){
    DisplayProductSubMenuBtn.addEventListener('click', displaySubmenu);
}