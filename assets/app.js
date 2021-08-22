/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// import codemirror from 'codemirror';
// import jquery from 'jquery';
// import jsPanel  from 'jspanel4';
// import contextmenu  from 'jquery-contextmenu';
require('jquery');
require('jquery-contextmenu');
// require('jspanel4');

import {jsPanel} from 'jspanel4';
// import {contextmenu} from 'jquery-contextmenu';
import './styles/loader.scss';
// import './scripts/filemanager.js';
// import './scripts/script.js';
// start the Stimulus application
import './bootstrap';

jsPanel.create({
    theme: 'dark',
    headerLogo: '<i class="fad fa-home-heart ml-2"></i>',
    headerTitle: 'I\'m a jsPanel',
    headerToolbar: '<span class="text-sm">Just some text in optional header toolbar ...</span>',
    footerToolbar: '<span class="flex flex-grow">You can have a footer toolbar too</span>'+
                   '<i class="fal fa-clock mr-2"></i><span class="clock">loading ...</span>',
    panelSize: {
        width: () => { return Math.min(800, window.innerWidth*0.9);},
        height: () => { return Math.min(500, window.innerHeight*0.6);}
    },
    animateIn: 'jsPanelFadeIn',
    contentAjax: {
        url: 'docs/sample-content/sampleContentHome.html',
        done: (xhr, panel) => {
            panel.content.innerHTML = xhr.responseText;
            Prism.highlightAll();
        }
    },
    onwindowresize: true,
    callback: function(panel) {
        function clock() {
            let time = new Date(),
                hours = time.getHours(),
                minutes = time.getMinutes(),
                seconds = time.getSeconds();
            panel.footer.querySelectorAll('.clock')[0].innerHTML = `${harold(hours)}:${harold(minutes)}:${harold(seconds)}`;
            function harold(standIn) {
                if (standIn < 10) {standIn = '0' + standIn;}
                return standIn;
            }
        }
        setInterval(clock, 1000);
    }
});
