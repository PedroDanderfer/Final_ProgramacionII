function displaySubmenu(e){
    if(e.target.tagName === 'SPAN'){
        var id = e.target.parentNode.attributes.id.value;
    }else{
        var id = e.target.attributes.id.value;
    }
    var menus = [];
    menus["DisplayProductSubMenuBtn"] = "ProductsSubmenu";
    menus["DisplayUserSubMenuBtn"] = "UserSubmenu";
    menus["DisplayShoppingCartSubMenuBtn"] = "ShoppingCartSubMenu";
    var menu = d.getElementById(menus[id]);

    if(menus[id] === undefined){
        return false;
    }

    if(menu.style.display === 'block'){
        menu.style.transform = 'translateY(-50px)';
        menu.style.display = 'none';
        if(menus[id] === 'ProductsSubmenu'){
            DisplayProductSubMenuBtn.style.backgroundImage = 'url(./site/images/arrow-down.png)';
        }else if(menus[id] === 'UserSubmenu'){
            UserSubMenuArrowSpan.style.backgroundImage = 'url(./site/images/arrow-down.png)';
        }
    }else{
        console.log(menus[id]);
        switch (menus[id]) {
            case 'ProductsSubmenu':
                if(d.getElementById('UserSubmenu')){
                    d.getElementById('UserSubmenu').style.display = 'none';
                }
                d.getElementById('ShoppingCartSubMenu').style.display = 'none';
                break;
            case 'UserSubmenu':
                d.getElementById('ProductsSubmenu').style.display = 'none';
                d.getElementById('ShoppingCartSubMenu').style.display = 'none';
            case 'ShoppingCartSubMenu':
                if(d.getElementById('UserSubmenu')){
                    d.getElementById('UserSubmenu').style.display = 'none';
                }
                d.getElementById('ProductsSubmenu').style.display = 'none';
            default:
                break;
        }
        menu.style.display ='block';
        if(window.screen.width > 600){
            menu.style.transform = 'translateY(50px)';
        }else{
            menu.style.transform = 'translateY(0px)';
        }
        if(menus[id] === 'ProductsSubmenu'){
            DisplayProductSubMenuBtn.style.backgroundImage = 'url(./site/images/arrow-up.png)';
        }else if(menus[id] === 'UserSubmenu'){
            UserSubMenuArrowSpan.style.backgroundImage = 'url(./site/images/arrow-up.png)';
        }
    }
}