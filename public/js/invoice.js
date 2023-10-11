let activeTabIndex = 1;
let numberOfTabs;

window.onload = function () {
    let tabs = document.querySelectorAll("#tabs .nav-item");
    numberOfTabs = tabs.length;

    for (let i = 0; i < tabs.length; i++) {
        tabs[i].querySelector(".nav-link").addEventListener("click", function (event) {
            event.preventDefault();
            let tabIndex = parseInt(this.parentElement.id.replace("tabHeader_", ""), 10);
            goToTabByIndex(tabIndex);
        });
    }

    goToTabByIndex(1);
};

function activateNavLink(tabIndex) {
    let navLink = document.getElementById("tabHeader_" + tabIndex).querySelector(".nav-link");
    navLink.classList.add("active");
    navLink.setAttribute("aria-selected", "true");
}

function deactivateNavLinks() {
    let navLinks = document.querySelectorAll(".nav-link");
    navLinks.forEach(function (navLink) {
        navLink.classList.remove("active");
        navLink.setAttribute("aria-selected", "false");
    });
}

function displayTab(tabIndex) {
    deactivateNavLinks();
    activateNavLink(tabIndex);
    document.getElementById("tabpage_" + tabIndex).style.display = "block";
}

function hideTab(tabIndex) {
    document.getElementById("tabpage_" + tabIndex).style.display = "none";
}

function goToTabByDelta(deltaIndex) {
    let newIndex = activeTabIndex + deltaIndex;

    if (newIndex < 1) {
        newIndex = numberOfTabs;
    } else if (newIndex > numberOfTabs) {
        newIndex = 1;
    }

    goToTabByIndex(newIndex);
}

function goToTabByIndex(newActiveTabIndex) {
    hideTab(activeTabIndex);
    displayTab(newActiveTabIndex);
    activeTabIndex = newActiveTabIndex;
}
