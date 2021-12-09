function displaySubmenu(e){
    var id = e.target.attributes.id.value, menus = [];
    menus["DisplayProductSubMenuBtn"] = "ProductsSubmenu";
    var menu = d.getElementById(menus[id]);    

    if(menus[id] === undefined){
        return false;
    }

    if(menu.style.display === 'block'){
        menu.style.transform = 'translateY(-50px)';
        menu.style.display = 'none';
        DisplayProductSubMenuBtn.style.backgroundImage = 'url(./site/images/arrow-down.png)';
    }else{
        menu.style.display ='block';
        menu.style.transform = 'translateY(0px)';
        DisplayProductSubMenuBtn.style.backgroundImage = 'url(./site/images/arrow-up.png)';
    }
}