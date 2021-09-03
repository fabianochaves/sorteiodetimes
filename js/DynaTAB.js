// Matheus Pollauf da Silva - 05/07/2021

/*

options = 
    [
        el: '',
        tabs: [
            {
                el = '',
                title = '',
                icon = '',
            }
        ],
    ]

*/

class DynaTAB {
    constructor(options) {
        this.element = document.querySelector(options.el);
        this.build(options);
    }

    build(options) {
        let tabsDiv = document.createElement('div');
        tabsDiv.className = "row";
        tabsDiv.style = "border-bottom: 1px lightgray solid;";

        let tabSizeFactor = Math.floor(12 / options.tabs.length);
        if (tabSizeFactor < 1)
            tabSizeFactor = 1;

        for (let tabIDX in options.tabs) {
            let dynaTab = options.tabs[tabIDX];
            let dynaTabEl = this.generateTab(dynaTab.el, tabSizeFactor, dynaTab.title, dynaTab.icon);
            tabsDiv.appendChild(dynaTabEl);
        }

        this.element.prepend(tabsDiv);

        let firstBtnTab = this.element.querySelector('.btnDynaTab');
        firstBtnTab.click();
    }

    generateTab(el, sizeFactor, titleText, iconClassName) {
        let tabEl = document.querySelector(el);
        tabEl.classList.add('dynaTab');
        tabEl.style.display = 'none';

        let tabDiv = document.createElement('div');
        tabDiv.className = "col-md-" + sizeFactor.toString();
        tabDiv.style = "padding: 0px;";

        let button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btnDynaTab btnDynaTabInactive';
        button.setAttribute('data-target', el);

        button.addEventListener("click", () => {
            this.hideAllTabs();

            tabEl.style.display = 'block';

            if (!button.classList.contains('btnDynaTabActive')) {
                button.classList.add('btnDynaTabActive');
                button.classList.remove('btnDynaTabInactive');
            }
        });

        let icon = document.createElement('i');
        icon.style = "margin-right: 2px";
        icon.setAttribute('aria-hidden', true);
        icon.className = iconClassName;

        let title = document.createElement('text');
        title.style = "margin-left: 2px";
        title.innerHTML = titleText;

        button.appendChild(icon);
        button.appendChild(title);

        tabDiv.appendChild(button);

        return tabDiv;
    }

    hideAllTabs() {
        let dynaTabs = this.element.querySelectorAll('.dynaTab'),
            i = 0,
            l = dynaTabs.length;

        for (i; i < l; i++) {
            dynaTabs[i].style.display = 'none';
        }

        this.disableAllTabs();
    }

    disableAllTabs() {
        let dynaTabs = this.element.querySelectorAll('.btnDynaTab'),
            i = 0,
            l = dynaTabs.length;

        for (i; i < l; i++) {
            dynaTabs[i].classList.add('btnDynaTabInactive');
            dynaTabs[i].classList.remove('btnDynaTabActive');
        }
    }
}

///////////////////////////////////////////////////////////

function createClass(name, rules) {
    var style = document.createElement('style');
    style.type = 'text/css';
    document.getElementsByTagName('head')[0].appendChild(style);
    if (!(style.sheet || {}).insertRule)
        (style.styleSheet || style.sheet).addRule(name, rules);
    else
        style.sheet.insertRule(name + "{" + rules + "}", 0);
}
createClass('.btnDynaTab', `
    width: 100% !important;
    margin-top: 1px !important;
`);

createClass('.btnDynaTabInactive', `
    background-color: transparent !important;
    border-radius: 0px !important;
`);

createClass('.btnDynaTabInactive:hover', `
    background-color: lightgray !important;
`);

createClass('.btnDynaTabActive', `
    background-color: #3f6ad8 !important;
    color: white !important;
    border-bottom: gray 1px solid !important;
    border-radius: 0px !important;
`);