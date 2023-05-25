var tabLinks = new Array();
var contentDivs = new Array();

function init() {
    var tabListItems = document.getElementById("tabs").childNodes;
    for (var i = 0; i < tabListItems.length; i++) {
        if (tabListItems[i].nodeName == "LI") {
            var tabLink = getFirstChildWithTagName(tabListItems[i], "A");
            var id = getHash(tabLink.getAttribute("href"));
            tabLinks[id] = tabLink;
            contentDivs[id] = document.getElementById(id);
        }
    }

    var i = 0;

    for (var id in tabLinks) {
        tabLinks[id].onclick = showTab;
        tabLinks[id].onfocus = function () {
            this.blur();
        };
        if (i == 0) tabLinks[id].className = "selected";
        i++;
    }

    var i = 0;

    for (var id in contentDivs) {
        if (i != 0) contentDivs[id].className = "tabContent hide";
        i++;
    }
}

function showTab() {
    var selectedId = getHash(this.getAttribute("href"));

    for (var id in contentDivs) {
        if (id == selectedId) {
            tabLinks[id].className = "selected";
            contentDivs[id].className = "tabContent";
        } else {
            tabLinks[id].className = "";
            contentDivs[id].className = "tabContent hide";
        }
    }

    return false;
}

function getFirstChildWithTagName(element, tagName) {
    for (var i = 0; i < element.childNodes.length; i++) {
        if (element.childNodes[i].nodeName == tagName)
            return element.childNodes[i];
    }
}

function getHash(url) {
    var hashPos = url.lastIndexOf("#");
    return url.substring(hashPos + 1);
}


// double tabs
// tabs clopsed
let tab = document.querySelector('.tabs');
let tabButtons = tab.querySelectorAll('[role="tab"]');
let tabPanels = Array.from(tab.querySelectorAll('[role="tabpanel"]'));

function tabClickHandler(e) {
	//Hide All Tabpane
	tabPanels.forEach(panel => {
		panel.hidden = 'true';
	});
	
	//Deselect Tab Button
	tabButtons.forEach( button => {
		button.setAttribute('aria-selected', 'false');
	});
	
	//Mark New Tab
	e.currentTarget.setAttribute('aria-selected', 'true');
	
	//Show New Tab
	const { id } = e.currentTarget;
	
	const currentTab = tabPanels.find(
		panel => panel.getAttribute('aria-labelledby') === id
	);
	
	currentTab.hidden = false;
}

tabButtons.forEach(button => {
	button.addEventListener('click', tabClickHandler);
});

// tabs2 clopsed
let tab1 = document.querySelector('.tabs1');
let tabButtons1 = tab.querySelectorAll('[role="tab1"]');
let tabPanels1 = Array.from(tab.querySelectorAll('[role="tabpanel1"]'));

function tabClickHandler1(e) {
	//Hide All Tabpane
	tabPanels.forEach(panel => {
		panel.hidden = 'true';
	});
	
	//Deselect Tab Button
	tabButtons1.forEach( button => {
		button.setAttribute('aria-selected', 'false');
	});
	
	//Mark New Tab
	e.currentTarget.setAttribute('aria-selected', 'true');
	
	//Show New Tab
	const { id } = e.currentTarget;
	
	const currentTab = tabPanels1.find(
		panel => panel.getAttribute('aria-labelledby') === id
	);
	
	currentTab.hidden = false;
}

tabButtons1.forEach(button => {
	button.addEventListener('click', tabClickHandler1);
});