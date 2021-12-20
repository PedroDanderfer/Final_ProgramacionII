const d = document;
var DisplayMenuBtn = d.getElementById("DisplayMenuBtn"), DisplayProductSubMenuBtn = d.getElementById("DisplayProductSubMenuBtn"), DisplayUserSubMenuBtn = d.getElementById("DisplayUserSubMenuBtn"), UserSubMenuArrowSpan = d.getElementById('UserSubMenuArrowSpan');

DisplayMenuBtn.addEventListener('click', displayMenu);
if(DisplayProductSubMenuBtn !== null){
    DisplayProductSubMenuBtn.addEventListener('click', displaySubmenu);
}
if(DisplayUserSubMenuBtn !== null){
    DisplayUserSubMenuBtn.addEventListener('click', displaySubmenu);
    UserSubMenuArrowSpan.addEventListener('click', displaySubmenu);
}