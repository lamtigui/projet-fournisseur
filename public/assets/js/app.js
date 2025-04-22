'use strict';

/* ===== Enable Bootstrap Popover (on element) ====== */
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

/* ==== Enable Bootstrap Alert ====== */
const alertList = document.querySelectorAll('.alert');
const alerts = [...alertList].map(element => new bootstrap.Alert(element));

/* ===== Sidebar Toggle Logic ====== */
document.addEventListener('DOMContentLoaded', function() {
    const sidePanelToggler = document.getElementById('sidepanel-toggler'); // Hamburger button
    const sidePanel = document.getElementById('app-sidepanel'); // Sidebar container
    const sidePanelDrop = document.getElementById('sidepanel-drop'); // Backdrop
    const sidePanelClose = document.getElementById('sidepanel-close'); // Close button
    const menuContent = document.querySelector('.templatemo-left-nav'); // Menu content (nav items)

    // Function to toggle sidebar
    function toggleSidebar() {
        if (sidePanel.classList.contains('sidepanel-visible')) {
            // If sidebar is open, close it
            sidePanel.classList.remove('sidepanel-visible');
            sidePanel.classList.add('sidepanel-hidden');
            sidePanelDrop.classList.remove('active'); // Hide backdrop
        } else {
            // If sidebar is closed, open it
            sidePanel.classList.remove('sidepanel-hidden');
            sidePanel.classList.add('sidepanel-visible');
            sidePanelDrop.classList.add('active'); // Show backdrop
        }
    }

    // Add event listeners only if elements exist to avoid errors
    if (sidePanelToggler) {
        sidePanelToggler.addEventListener('click', toggleSidebar);
    }

    if (sidePanelClose) {
        sidePanelClose.addEventListener('click', function(e) {
            e.preventDefault();
            toggleSidebar();
        });
    }

    if (sidePanelDrop) {
        sidePanelDrop.addEventListener('click', toggleSidebar);
    }
});

/* ===== Responsive Sidebar Behavior ====== */
function responsiveSidePanel() {
    const sidePanel = document.getElementById('app-sidepanel');
    let screenWidth = window.innerWidth;

    if (screenWidth >= 1200) {
        // Always show sidebar on large screens
        sidePanel.classList.remove('sidepanel-hidden');
        sidePanel.classList.add('sidepanel-visible');
    } else {
        // Hide sidebar on smaller screens
        sidePanel.classList.remove('sidepanel-visible');
        sidePanel.classList.add('sidepanel-hidden');
    }
}

// Run on page load and screen resize
window.addEventListener('load', responsiveSidePanel);
window.addEventListener('resize', responsiveSidePanel);

/* ====== Mobile Search Toggle ======= */
const searchMobileTrigger = document.querySelector('.search-mobile-trigger');
const searchBox = document.querySelector('.app-search-box');

if (searchMobileTrigger) {
    searchMobileTrigger.addEventListener('click', () => {
        searchBox.classList.toggle('is-visible');

        let searchMobileTriggerIcon = document.querySelector('.search-mobile-trigger-icon');
        if (searchMobileTriggerIcon.classList.contains('fa-magnifying-glass')) {
            searchMobileTriggerIcon.classList.remove('fa-magnifying-glass');
            searchMobileTriggerIcon.classList.add('fa-xmark');
        } else {
            searchMobileTriggerIcon.classList.remove('fa-xmark');
            searchMobileTriggerIcon.classList.add('fa-magnifying-glass');
        }
    });
}
