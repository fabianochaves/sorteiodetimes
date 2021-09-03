// MPS - 12/05/2021

let menuAberto = null;

function mapMenusDropdownDinamicos() {
    let menus = {};

    let uls = $('.menuDropdownDinamico');
    uls.each((ulIndex) => {
        let menu = { data: [] };
        let ul = uls[ulIndex];

        menu.data = getMenuItens(ul);

        menus[ulIndex] = {
            buttonID: $('#' + $(ul).attr('data-button-id'))[0],
            options: menu,
        };
    });

    for (var menuIndex in menus) {
        let menuInfo = menus[menuIndex];
        MenuDropdownFactory.create(menuInfo.buttonID, menuInfo.options);
    }
}

function getMenuItens(ul) {
    let itens = {};

    let lis = $(ul).children('li');

    lis.each((liIndex) => {
        let li = lis[liIndex];
        let a = $(li).children('a')[0];

        if (a == null)
            a = $(li).children('div')[0];

        let item = {
            content: $(a).html(),
            action: $(li).attr('onclick'),
            data: getMenuSubmenus(li),
        };

        itens[liIndex] = item;
    });

    return itens;
}

function getMenuSubmenus(li) {
    let submenus = {};
    let uls = $(li).children('ul');

    if (uls.length > 0) {
        uls.each((ulIndex) => {
            let ul = uls[ulIndex];
            let itens = getMenuItens(ul);
            submenus[ulIndex] = itens;
        });

        return submenus[0];
    }

    return null;
}

$(document).ready(function () {
    document.addEventListener('scroll', function (e) {
        if (menuAberto != null && e.target != document) {
            menuAberto.close();
        }
    }, true);

    $(document).click(function (e) {
        if (menuAberto != null) {
            let element = menuAberto.getElement();
            if (!element.contains(e.target)) {
                menuAberto.close();
            }
        }
    });
});

class MenuDropdownFactory {
    static create(button, options) {
        let menu = new MenuDropdown(options);

        $(button).click(function (e) {
            let isVisible =
                menuAberto != null
                    ? menuAberto.getElement() == menu.getElement()
                    : false;

            if (isVisible) {
                menu.close();
            }
            else {
                let positions =
                {
                    x: e.pageX,
                    y: e.pageY
                }

                let windowHeight = window.innerHeight;
                let menuHeight = $(menu.getElement()).outerHeight();
                let tamanhoExtrapolado = windowHeight - positions.y - menuHeight;

                let windowRealHeight = $(window).height();
                let windowScrollTop = document.body.scrollTop;

                let positionYProportion = (positions.y - windowScrollTop) / windowRealHeight;

                let proportionalSizePositionY = windowHeight * positionYProportion;

                let limitWindowHeight = windowHeight * 0.35;

                if (tamanhoExtrapolado < 0 && proportionalSizePositionY >= limitWindowHeight) {
                    positions.y -= menuHeight;
                }

                console.log('Position Y Proportion:', positionYProportion);
                console.log('Proportional Size Position Y:', proportionalSizePositionY);
                console.log('Limit Window Height:', limitWindowHeight);

                menu.open(positions);
            }
        });
    }
}

class MenuDropdown {
    constructor(options) {
        this.element = this.build(options);
    }

    build(options) {
        let div = document.createElement('div');
        div.className = "dropdown-menu-dinamico";
        div.style =
            `
                display: none;
                position: absolute;
                z-index: 9999999;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                        user-select: none;
            `;

        let ul = document.createElement('ul');
        ul.style = "margin: 0px; padding: 0px;";

        ul = this.buildChilds(ul, options);

        div.appendChild(ul);
        document.body.appendChild(div);

        return div;
    }

    buildChilds(ul, options) {
        for (let index in options.data) {
            let option = options.data[index];

            const doAction = () => {
                if (option.action != null && option.action != '' && option.action != '//none') {
                    eval(option.action);
                    this.close();
                }
            };

            let li = document.createElement('li');

            if (option.action != '//none') {
                li.className = "dropdown-item";
            }
            else {
                li.className = "dropdown-item";
                li.style = "background-color: transparent !important";
            }

            let a = option.action != '//none' ? document.createElement('a') : document.createElement('div');
            a.innerHTML = option.content;

            let anotherA = $(a).find('a');
            if (anotherA != null) {
                $(anotherA).click((e) => doAction());
            }
            else {
                $(li).click((e) => doAction());
            }

            if (option.data != null) {
                a.innerHTML += ' <i class="fa fa-caret-right" aria-hidden="true"></i>';

                let ulChild = document.createElement('ul');
                ulChild.className = "dropdown-menu-dinamico ulChild";
                ulChild.style = "position: absolute; left: 100%;";
                ulChild = this.buildChilds(ulChild, option);
                li.appendChild(ulChild);

                $(li).click((e) => {
                    let isChildVisible = $(ulChild).css('display') != 'none';

                    if (isChildVisible)
                        $(ulChild).hide();
                    else
                        $(ulChild).show();

                    return false;
                });
            }
            else {
                a.href = '#';
            }

            li.appendChild(a);
            ul.appendChild(li);
        }

        return ul;
    }

    open(positions) {
        setTimeout(() => {
            menuAberto = this;
            $(this.element).css({
                "left": positions.x + 'px',
                "top": positions.y + 'px'
            })
            $(this.element).find('.ulChild').hide();
            $(this.element).show();
        }, 100);
    }

    close() {
        menuAberto = null;
        $(this.element).hide();
    }

    getElement() {
        return this.element;
    }
}